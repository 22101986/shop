<?php

namespace App\Controller;

use App\Entity\Products;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HumourController extends AbstractController
{
    #[Route('/humour', name: 'app_humour')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $products =$doctrine->getRepository(Products::class)->findByCategory("humour");
        return $this->render('humour/index.html.twig',[
            'products' => $products,
        ]);
    }
}
