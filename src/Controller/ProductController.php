<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Category;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="app_product")
     * @IsGranted("ROLE_USER")
     */
    public function index(ProductRepository $productRepository)
    {
        $data['produtos'] = $productRepository->findAll();
        $data['titulo'] = "Gerir Produtos";

        return $this->render('product/index.html.twig', $data);
    }

    /**
     * @Route("/product/add", name="add_product")
     * @IsGranted("ROLE_USER")
     */
    public function adicionar(Request $request, EntityManagerInterface $em): Response 
    {
        $msg = '';
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em->persist($product);
            $em->flush();
            $msg = "Produto criado com sucesso!";
        }

        $data['titulo'] = 'Adicionar novo produto';
        $data['form'] = $form;
        $data['msg'] = $msg;

        return $this->renderForm('product/form.html.twig', $data);
    }

    /**
     * @Route("/product/edit/{id}", name="edit_product")
     * @IsGranted("ROLE_USER")
     */
    public function editar($id, Request $request, EntityManagerInterface $em, ProductRepository $productRepository): Response
    {
        $msg = '';
        $product = $productRepository->find($id);
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em->flush();   
            $msg = 'Produto atualizado com sucesso!';
        }

        $data['titulo'] = 'Editar produto';
        $data['form'] = $form;
        $data['msg'] = $msg;

        return $this->renderForm('product/form.html.twig', $data);
    }

    /**
     * @Route("/product/delete/{id}", name="delete_product")
     * @IsGranted("ROLE_USER")
     */
    public function apagar($id, EntityManagerInterface $em, ProductRepository $productRepository): Response
    {
        $product = $productRepository->find($id);
        
        $em->remove($product);
        $em->flush();

        return $this->redirectToRoute('app_product');
    }
}
