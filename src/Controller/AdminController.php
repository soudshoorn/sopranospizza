<?php

namespace App\Controller;

use App\Repository\OrdersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin/dashboard', name: 'admin_dashboard')]
    public function AdminDashboard(OrdersRepository $ordersRepository): Response
    {
        $orders = $ordersRepository->findAll();
        $ordersArray = [];
        foreach($orders AS $order) {
            $ordersArray[] = ['orders' => $order];
        }
        return $this->render('admin/dashboard.html.twig', [
            'controller_name' => 'RoutesController',
            'orders' => $ordersArray
        ]);
    }
}
