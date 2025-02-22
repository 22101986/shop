<?php

namespace App\Controller;

use App\Entity\Products;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ComedyController extends AbstractController
{
    #[Route('/comedy', name: 'app_comedy')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $products =$doctrine->getRepository(Products::class)->findByCategory("comedy");
        return $this->render('comedy/index.html.twig',[
            'products' => $products,
        ]);
    }
}