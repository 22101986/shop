<?php

namespace App\Controller;

use App\Entity\Products;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FantastiqueController extends AbstractController
{
    #[Route('/fantastique', name: 'app_fantastique')]
    
    public function index(ManagerRegistry $doctrine): Response
    {
        $products =$doctrine->getRepository(Products::class)->findByCategory("fantastique");
        return $this->render('fantastique/index.html.twig',[
            'products' => $products,
        ]);
    }
}
