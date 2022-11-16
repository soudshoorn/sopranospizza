<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Form\OrderType;
use App\Form\PizzaType;
use App\Repository\CategoriesRepository;
use App\Repository\OrdersRepository;
use App\Repository\PizzaRepository;
use Doctrine\ORM\Mapping\Id;
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
    public function index(CategoriesRepository $categoriesRepository): Response
    {
        return $this->render('pages/homepage.html.twig', [
            'categories' => $categoriesRepository->findAll(),
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
            $cart = $request->request->all();
            $cart['pizza']['name'] = $pizza->getName();
            $cart['pizza']['price'] = $pizza->getPrice();
            $cart['pizza']['id'] = $pizza->getId();
            $sessionCart = $session->get('cart');
            $sessionCart[] = $cart;
            $session->set('cart', $sessionCart);

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
        if ($user) {
            $userId = $user->getId();
            $userEmail = $user->getEmail();
        } else {
            $userId = null;
            $userEmail = '';
        }

        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);
        $orderArray[] = $session->get('cart');
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $description = "";
            $price = 0;
            $cart = $session->get('cart');
            $lastItem = end($cart);
            foreach ($cart as $cartItem) {
                if ($cartItem == $lastItem) {
                    $description = $description . $cartItem['pizza']['name'] . "." . $cartItem['pizza']['size'] . "." . $cartItem['pizza']['topping'];
                } else {
                    $description = $description . $cartItem['pizza']['name'] . "." . $cartItem['pizza']['size'] . "." . $cartItem['pizza']['topping'] . "!";
                }
                $price = $price + $cartItem['pizza']['price'];
            }

            $order->setDescription($description);
            $order->setPrice($price);
            $order->setStatus("To Do");
            $order->setUserId($userId);
            $entityManager->persist($order);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Je bestelling is succesvol geplaatst. Bedankt!'
            );
            $session->remove('cart');
            return $this->redirectToRoute('index');
        }

        return $this->render('pages/checkout.html.twig', [
            'email' => $userEmail,
            'order' => $orderArray,
            'form' => $form->createView(),
            'controller_name' => 'RoutesController',
        ]);
    }

    #[Route('/checkoutdelete/{id}', name: 'app_checkoutdelete')]
    public function CheckoutDelete(int $id): Response
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart');
        unset($cart[$id]);
        $session->set('cart', $cart);

        return $this->redirectToRoute('app_checkout');
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
