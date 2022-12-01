<?php

namespace App\Controller;

use App\Repository\ProductsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ProductsRepository $productsRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'User',
            'products' => $productsRepository->findAll(),
        ]);
    }
}
