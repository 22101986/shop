<?php

namespace App\Controller;

use App\Entity\File;
use App\Entity\News;
use App\Repository\FileRepository;
use App\Repository\NewsRepository;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LeftSideController extends AbstractController
{
    #[Route('/left/side', name: 'app_left_side')]
    public function leftside(): Response
    {
        
        
        return $this->render('left_side/leftSide.html.twig');
    }

    
}
