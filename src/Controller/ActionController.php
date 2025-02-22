<?php

namespace App\Controller;

use App\Entity\Products;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ActionController extends AbstractController
{
    #[Route('/action', name: 'app_action')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $products =$doctrine->getRepository(Products::class)->findByCategory("action");
        return $this->render('action/index.html.twig',[
            'products' => $products,
        ]);
    }
}
