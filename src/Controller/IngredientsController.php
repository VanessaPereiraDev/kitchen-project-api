<?php

namespace App\Controller;

use App\Entity\Ingredients;
use App\Form\IngredientsType;
use App\Repository\IngredientsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class IngredientsController extends AbstractController
{
    /**
     * @Route("/ingredients", name="app_ingredients")
     * @IsGranted("ROLE_USER")
     */
    public function index(IngredientsRepository $ingredientsRepository)
    {
        $data['ingredients'] = $ingredientsRepository->findAll();
        $data['titulo'] = "Gerir Ingredientes";

        return $this->render('ingredients/index.html.twig', $data);
    }

     /**
     * @Route("/ingredients/add", name="add_ingredients")
     * @IsGranted("ROLE_USER")
     */
    public function adicionar(Request $request, EntityManagerInterface $em): Response 
    {
        $msg = '';
        $ingredients = new Ingredients();
        $form = $this->createForm(IngredientsType::class, $ingredients);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em->persist($ingredients);
            $em->flush();
            $msg = "Ingredientes adicionados com sucesso!";
        }

        $data['titulo'] = 'Adicionar ingredientes';
        $data['form'] = $form;
        $data['msg'] = $msg;

        return $this->renderForm('ingredients/form.html.twig', $data);
    }

    /**
     * @Route("/ingredients/edit/{id}", name="edit_ingredients")
     * @IsGranted("ROLE_USER")
     */
    public function editar($id, Request $request, EntityManagerInterface $em, IngredientsRepository $ingredientsRepository): Response
    {
        $msg = '';
        $ingredients = $ingredientsRepository->find($id);
        $form = $this->createForm(IngredientsType::class, $ingredients);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em->flush();   
            $msg = 'Ingredientes atualizados com sucesso!';
        }

        $data['titulo'] = 'Editar ingredientes';
        $data['form'] = $form;
        $data['msg'] = $msg;

        return $this->renderForm('ingredients/form.html.twig', $data);
    }

     /**
     * @Route("/ingredients/delete/{id}", name="delete_ingredients")
     * @IsGranted("ROLE_USER")
     */
    public function apagar($id, EntityManagerInterface $em, IngredientsRepository $ingredientsRepository): Response
    {
        $ingredients = $ingredientsRepository->find($id);
        
        $em->remove($ingredients);
        $em->flush();

        return $this->redirectToRoute('app_ingredients');
    }
}
