<?php

namespace App\Controller;

use App\Form\PizzaType;
use App\Repository\CategoriesRepository;
use App\Repository\OrdersRepository;
use App\Repository\PizzaRepository;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class RoutesController extends AbstractController
{
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
            $session = new Session();

            $session->set('name', $pizza->getName());
            $session->set('size', $form->getData()["size"]);
            $session->set('topping', $form->getData()["topping"]);


        }

        return $this->render('pages/pizza.html.twig', [
            'pizza' => $pizzaRepository->findOneBy(['id' => $pizza]),
            'form' => $form->createView(),
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
