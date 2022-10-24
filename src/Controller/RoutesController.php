<?php

namespace App\Controller;

use App\Repository\OrdersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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

    #[Route('/dashboard', name: 'dashboard')]
    public function AdminDashboard(OrdersRepository $ordersRepository): Response
    {
        $orders = $ordersRepository->findAll();
        $ordersArray = [];
        foreach($orders AS $order) {
            $ordersArray[] = ['orders' => $order];
        }
        return $this->render('pages/dashboard.html.twig', [
            'controller_name' => 'RoutesController',
            'orders' => $ordersArray
        ]);
    }
}
