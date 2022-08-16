<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Category;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController 
{
    /**
     * @Route("/api", name="app_api")
     */
    public function products(ProductRepository $productRepository): Response
    {
        $listProducts = $productRepository->findAll();
        return $this->json(
            $listProducts,
            200,
            [],
            ['groups' => ['api_list']]
        );   
    }
}