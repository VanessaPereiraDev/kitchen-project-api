<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="app_category")
     * @IsGranted("ROLE_USER")
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        $data['categorias'] = $categoryRepository->findAll();
        $data['titulo'] = 'Gerir Categorias';

        return $this->render('category/index.html.twig', $data);
    }

     /**
     * @Route("/category/add", name="add_category")
     * @IsGranted("ROLE_USER")
     */
    public function adicionar(Request $request, EntityManagerInterface $em): Response 
    {
        $msg = '';
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em->persist($category);
            $em->flush();
            $msg = "Categoria adicionada com sucesso!";
        }

        $data['titulo'] = 'Adicionar nova categoria';
        $data['form'] = $form;
        $data['msg'] = $msg;

        return $this->renderForm('category/form.html.twig', $data);
    }

     /**
     * @Route("/category/edit/{id}", name="edit_category")
     * @IsGranted("ROLE_USER")
     */
    public function editar($id, Request $request, EntityManagerInterface $em, CategoryRepository $categoryRepository): Response
    {
        $msg = '';
        $category = $categoryRepository->find($id);
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em->flush();   //Faz o UPDATE da categoria na BD.
            $msg = 'Produto atualizado com sucesso!';
        }

        $data['titulo'] = 'Editar categoria';
        $data['form'] = $form;
        $data['msg'] = $msg;

        return $this->renderForm('category/form.html.twig', $data);
    }

     /**
     * @Route("/category/delete/{id}", name="delete_category")
     * @IsGranted("ROLE_USER")
     */
    public function apagar($id, EntityManagerInterface $em, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->find($id);
        
        $em->remove($category);
        $em->flush();

        //redirecionar a aplicação para o app_category
        return $this->redirectToRoute('app_category');
    }
}
