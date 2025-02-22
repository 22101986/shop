<?php

namespace App\Controller;

use App\Entity\Products;
use App\Repository\CartRepository;
use App\Repository\ProductsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ShopController extends AbstractController
{
    
    
    
    #[Route('/shop', name: 'shop')]
    public function index(ManagerRegistry $doctrine, SessionInterface $session, ProductsRepository $productsRepository): Response
    {   
        $products = $productsRepository->findAll();
        $prod = $productsRepository->findAll();

        // $product = $session->get('product',[]);
        // $productWithData = [];
        // $a;

        // foreach($product as $id =>$a) {
        //     $productWithData[] = [
        //         'product' => $productsRepository->find($id),
        //         'a' => $a
                
        //     ]; 
        
        // $products =$doctrine->getRepository(Products::class)->findAll();
        $names = [];
        $descriptions = [];
        $pictures = [];
        $prices = [];
        $identitys = [];
        $i;
        $is = [];
        
            

        foreach ($products as $product) {
            array_push($names, $product->getName());
            array_push($pictures, $product->getPicture());
            array_push($prices, $product->getPrice());
            array_push($descriptions, $product->getDescription());
            array_push($identitys, $product->getId());
        }
        
        return $this->render('shop/shop.html.twig', [
            'products' => $products,
            'prod' => $prod,
            'names' => $names,
            'descriptions' => $descriptions,
            'pictures' => $pictures,
            'prices' => $prices,
            'identitys' => $identitys
            

        ]);
    }
    
    
    #[Route('/add', name: 'add')]
    public function create(Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger): Response
    {
        $entityManager = $doctrine->getManager();

        $products = new Products();
        
        $form = $this->createFormBuilder($products)

        ->add('name', TextType::class, [
            'label' => 'nom',
            'attr' => [
                'class' => 'form-control mb-4'
            ]
         ]) 

        ->add('price', MoneyType::class, [
            
            'label' => "Prix en ",
            'attr' => [
                'class' => 'form-control mb-4'
            ]
        ])

        ->add('description', TextareaType::class, [
            'label' => 'description du produit',
            'attr' => [
                'class' => 'form-control mb-4'
            ]
         ])

         ->add('lildescription', TextType::class, [
            'label' => 'description du produit',
            'attr' => [
                'class' => 'form-control mb-4'
            ]
         ])

         ->add('picture', FileType::class, [
            'label' => 'Votre photo :',
            'required' => true,
            'constraints' => [
                new File([
                    'maxSize' => '10512k',
                    'mimeTypes' => [
                        'image/jpg',
                        'image/jpeg',
                        'image/svg',
                        'image/png',
                    ],
                    'mimeTypesMessage' => 'Merci de choisir une photo valide ".jpg ,.jpeg ,.svg ,.png" et inférieur à 10512Ko.',
                ])
            ],
        ])

        ->add('category', ChoiceType::class, [
            'label' => 'catégorie',
            'attr' => [
                'class' => 'form-control mb-4 w-100'
            ],
            'choices' => [
                'action' => 'action', 
                'comedy' => 'comedy',
                'fantastique' => 'fantastique',
                'animation' => 'animation',
                'drame' => 'drame',
                'humour' => 'humour'
            ],
        ]) 

        ->add('save', SubmitType::class, [
            'label' => "ajouter l'article",
            'attr' => [
                'class' => 'btn btn-success m-5'
                ]])

        
       
         
        
        ->getForm();

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $picture = $form->getData();
            $pictureFile = $form->get('picture')->getData();
            if ($pictureFile) {
                $originalFilename = pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $pictureFile->guessExtension();
                $pictureFile->move(
                    $this->getParameter('uploads_directory'),
                    $newFilename
                    
                );
                $picture->setPicture($newFilename);
            }


            $entityManager->persist($picture);
            $entityManager->flush();

            return $this->redirectToRoute('page');
        }

        return $this->renderForm('shop/add.html.twig', [
        'form' => $form,
    ]);
    }
    #[Route('/edit/{id}', name: 'edit')]
    public function edit(Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger, int $id,Products $builder): Response
    {   $entityManager = $doctrine->getManager();
        $product = $entityManager->getRepository(Products::class)->find($id);
       
        $form = $this->createFormBuilder($product)

        ->add('name', TextType::class, [
            'label' => 'nom',
            'attr' => [
                'class' => 'form-control mb-4'
            ]
         ]) 

        ->add('price', MoneyType::class, [
            
            'label' => "Prix en ",
            'attr' => [
                'class' => 'form-control mb-4'
            ]
        ])

        ->add('description', TextareaType::class, [
            'label' => 'résumé du film',
            'attr' => [
                'class' => 'form-control mb-4'
            ]
         ])

         ->add('lildescription', TextType::class, [
            'label' => 'brève description',
            'attr' => [
                'class' => 'form-control mb-4'
            ]
         ])

         ->add('picture', FileType::class, [
            'label' => 'Votre photo :',
            'required' => true,
            'data_class' => null,
            'constraints' => [
                new File([
                    'maxSize' => '10512k',
                    'mimeTypes' => [
                        'image/jpg',
                        'image/jpeg',
                        'image/svg',
                        'image/png',
                    ],
                    'mimeTypesMessage' => 'Merci de choisir une photo valide ".jpg ,.jpeg ,.svg ,.png" et inférieur à 10512Ko.',
                ])
            ],
        ])

        ->add('category', ChoiceType::class, [
            'label' => 'catégorie',
            'attr' => [
                'class' => 'form-control mb-4'
            ],
            'choices' => [
                'action' => 'action', 
                'comedy' => 'comedy',
                'fantastique' => 'fantastique',
                'animation' => 'animation',
                'drame' => 'drame',
                'humour' => 'humour'
            ],
        ]) 

        ->add('save', SubmitType::class, [
            'label' => "modifier l'article",
            'attr' => [
                'class' => 'btn btn-success m-5'
                ]])

        
        ->getForm();

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $picture = $form->getData();
            $pictureFile = $form->get('picture')->getData();
            if ($pictureFile) {
                $originalFilename = pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $pictureFile->guessExtension();
                $pictureFile->move(
                    $this->getParameter('uploads_directory'),
                    $newFilename
                    
                );
                $picture->setPicture($newFilename);
            }


            $entityManager->persist($picture);
            $entityManager->flush();

            return $this->redirectToRoute('page');
        }

        return $this->renderForm('shop/edit.html.twig', [
        'form' => $form,
    ]);  
        
        
    }

    
    #[Route('/delete/{id}', name: 'delete')]
    public function remove(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();

        $product = $entityManager->getRepository(Products::class)->find($id);

        $entityManager->remove($product);
        $entityManager->flush();

        $this->addFlash('danger', 'Article supprimé avec succes');

        return $this->redirectToRoute('app_admin');
    }

    
}
