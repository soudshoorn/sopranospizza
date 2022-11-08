<?php

namespace App\Controller;

use App\Entity\Pizza;
use App\Form\NewPizzaType;
use App\Form\OrderType;
use App\Form\StatusType;
use App\Repository\CategoriesRepository;
use App\Repository\OrdersRepository;
use App\Repository\PizzaRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AdminController extends AbstractController
{
    #[Route('/admin/dashboard', name: 'admin_dashboard')]
    public function AdminDashboard(UserRepository $userRepository, OrdersRepository $ordersRepository, \Symfony\Component\HttpFoundation\Request $request): Response
    {
        $orders = $ordersRepository->findAll();
        $ordersArray = [];
        foreach ($orders as $order) {
            unset($descriptionText);
            $user = $userRepository->findOneBy(['id' => $order->getUserId()]);
            if ($user !== null) {
                $userEmail = $user->getEmail();
            } else {
                $userEmail = "Gast";
            }

            $descriptionsArray = explode("!", $order->getDescription());
            foreach ($descriptionsArray as $description) {
                $descriptionText[] = explode(".", $description);
            }

            $ordersArray[] = ['orders' => $order, 'email' => $userEmail, 'descriptions' => $descriptionText];
        }

        return $this->render('admin/dashboard.html.twig', [
            'controller_name' => 'AdminController',
            'orders' => $ordersArray
        ]);
    }

    #[Route('/admin/statuschange/{id}', name: 'admin_statuschange')]
    public function StatusChange(OrdersRepository $ordersRepository, \Symfony\Component\HttpFoundation\Request $request, int $id, ManagerRegistry $doctrine): Response
    {
        $order = $ordersRepository->findOneBy(['id' => $id]);
        $entityManager = $doctrine->getManager();
        if ($order->getStatus() == 'To Do') {
            $order->setStatus("In Progress");
        } else if ($order->getStatus() == 'In Progress') {
            $order->setStatus("Done");
        } else {
            $order->setStatus("To Do");
        }

        $entityManager->persist($order);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Status succesvol veranderd!'
        );
        return $this->redirectToRoute('admin_dashboard');
    }

    #[Route('/admin/menu', name: 'admin_menu')]
    public function MenuManagement(PizzaRepository $pizzaRepository, CategoriesRepository $categoriesRepository): Response
    {
        $pizzas = $pizzaRepository->findAll();
        $pizzasArray = [];

        foreach ($pizzas as $pizza) {
            $category = $categoriesRepository->findOneBy(['id' => $pizza->getCategoryId()]);
            $categoryName = $category->getName();
            $pizzasArray[] = ['pizzas' => $pizza, 'category' => $categoryName];
        }
        return $this->render('admin/menu.html.twig', [
            'pizzas' => $pizzasArray,
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/admin/menu/new', name: 'admin_menunew')]
    public function NewPizza(\Symfony\Component\HttpFoundation\Request $request, ManagerRegistry $doctrine): Response
    {
        $pizza = new Pizza();
        $form = $this->createForm(NewPizzaType::class, $pizza);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $pizzaImage = $form->get('img')->getData();
            if ($pizzaImage !== null) {
                $fileFolder = __DIR__ . '/../../public/img/';
                $filePathName = md5(uniqid()) . $pizzaImage->getClientOriginalName();
                try {
                    $pizzaImage->move($fileFolder, $filePathName);
                } catch (FileException $e) {
                    $this->addFlash(
                        'danger',
                        'Er is een fout opgetreden, probeer het later opnieuw.'
                    );
                    return $this->redirectToRoute('admin_menu');
                }
            }
            $pizza->setImg($filePathName);
            $entityManager->persist($pizza);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Het nieuwe product is succesvol toegevoegd!'
            );
            return $this->redirectToRoute('index');
        }

        return $this->render('admin/new.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/admin/menu/edit/{id}', name: 'admin_menuedit')]
    public function EditPizza(\Symfony\Component\HttpFoundation\Request $request, ManagerRegistry $doctrine, int $id, PizzaRepository $pizzaRepository): Response
    {
        $pizza = $pizzaRepository->findOneBy(['id' => $id]);
        $form = $this->createForm(NewPizzaType::class, $pizza);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $pizzaImage = $form->get('img')->getData();
            if ($pizzaImage !== null) {
                $fileFolder = __DIR__ . '/../../public/img/';
                $filePathName = md5(uniqid()) . $pizzaImage->getClientOriginalName();
                try {
                    $pizzaImage->move($fileFolder, $filePathName);
                } catch (FileException $e) {
                    $this->addFlash(
                        'danger',
                        'Er is een fout opgetreden, probeer het later opnieuw.'
                    );
                    return $this->redirectToRoute('admin_menu');
                }
                $pizza->setImg($filePathName);
            }

            $entityManager->persist($pizza);
            $entityManager->flush();


            $this->addFlash(
                'success',
                'Het product is succesvol gewijzigd!'
            );
            return $this->redirectToRoute('index');
        }

        return $this->render('admin/new.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/admin/menu/delete/{id}', name: 'admin_menudelete')]
    public function DeletePizza(\Symfony\Component\HttpFoundation\Request $request, ManagerRegistry $doctrine, PizzaRepository $pizzaRepository, int $id): Response
    {
        $pizza = $pizzaRepository->findOneBy(['id' => $id]);
        $entityManager = $doctrine->getManager();
        $entityManager->remove($pizza);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Pizza succesvol verwijderd!'
        );
        return $this->redirectToRoute('admin_dashboard');
    }
}
