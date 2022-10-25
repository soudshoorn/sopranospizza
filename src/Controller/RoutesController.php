<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Form\OrderType;
use App\Form\PizzaType;
use App\Repository\CategoriesRepository;
use App\Repository\OrdersRepository;
use App\Repository\PizzaRepository;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\DebugBundle;

class RoutesController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('pages/homepage.html.twig', [
            'controller_name' => 'RoutesController',
        ]);
    }

    #[Route('/categories', name: 'app_categories')]
    public function PizzaCategories(CategoriesRepository $categoriesRepository): Response
    {
        return $this->render('pages/categories.html.twig', [
            'categories' => $categoriesRepository->findBy(array(), ['name' => 'asc']),
            'controller_name' => 'RoutesController',
        ]);
    }

    #[Route('/category/{category}', name: 'app_category')]
    public function PizzaCategory(PizzaRepository $pizzaRepository, string $category): Response
    {
        return $this->render('pages/category.html.twig', [
            'pizzas' => $pizzaRepository->findBy(['category_id' => $category]),
            'controller_name' => 'RoutesController',
        ]);
    }

    #[Route('/pizza/{pizza}', name: 'app_pizza')]
    public function PizzaProduct(PizzaRepository $pizzaRepository, string $pizza, \Symfony\Component\HttpFoundation\Request $request): Response
    {
        $pizza = $pizzaRepository->findOneBy(['id' => $pizza]);

        $form = $this->createForm(PizzaType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $session = $this->requestStack->getSession();
            $session->set('name', $pizza->getName());
            $session->set('price', $pizza->getPrice());
            $session->set('size', $form->getData()["size"]);
            $session->set('topping', $form->getData()["topping"]);

            return $this->redirectToRoute('app_checkout');
        }

        return $this->render('pages/pizza.html.twig', [
            'pizza' => $pizzaRepository->findOneBy(['id' => $pizza]),
            'form' => $form->createView(),
            'controller_name' => 'RoutesController',
        ]);
    }

    #[Route('/checkout', name: 'app_checkout')]
    public function OrderCheckout(\Symfony\Component\HttpFoundation\Request $request, ManagerRegistry $doctrine): Response
    {
        $session = $this->requestStack->getSession();
        $order = new Orders();
        $user = $this->getUser();
        if($user) {
            $userid = $user->getId();
            $useremail = $user->getEmail();
        } else {
            $userid = null;
            $useremail = '';
        }
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        $orderArray[] = ['name' => $session->get('name'), 'price' => $session->get('price'), 'size' => $session->get('size'), 'topping' => $session->get('topping')];

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $order->setDescription($session->get('name') . ", " . $session->get('size') . ", " . $session->get('topping'));
            $order->setPrice($session->get('price'));
            $order->setStatus("To Do");
            $order->setUserId($userid);
            $entityManager->persist($order);
            $entityManager->flush();


            $this->addFlash(
                'success',
                'Je bestelling is succesvol geplaatst. Bedankt!'
            );
            return $this->redirectToRoute('index');
        }

        return $this->render('pages/checkout.html.twig', [
            'email' => $useremail,
            'order' => $orderArray,
            'form' => $form->createView(),
            'controller_name' => 'RoutesController',
        ]);
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(): Response
    {
        return $this->render('pages/contact.html.twig', [
            'controller_name' => 'RoutesController',
        ]);
    }

    #[Route('/dashboard', name: 'app_dashboard')]
    public function UserDashboard(): Response
    {
        return $this->render('pages/dashboard.html.twig', [
            'controller_name' => 'RoutesController',
        ]);
    }
}
