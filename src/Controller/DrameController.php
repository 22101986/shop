<?php

namespace App\Controller;

use App\Entity\Products;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DrameController extends AbstractController
{
    #[Route('/drame', name: 'app_drame')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $products =$doctrine->getRepository(Products::class)->findByCategory("drame");
        return $this->render('drame/index.html.twig',[
            'products' => $products,
        ]);
    }
}
