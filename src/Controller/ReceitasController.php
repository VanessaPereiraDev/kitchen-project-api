<?php

namespace App\Controller;

use App\Entity\Receitas;
use App\Form\ReceitasType;
use App\Repository\ReceitasRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ReceitasController extends AbstractController
{
    /**
     * @Route("/receitas", name="app_receitas")
     * @IsGranted("ROLE_USER")
     */
    public function index(ReceitasRepository $receitasRepository)
    {
        $data['receitas'] = $receitasRepository->findAll();
        $data['titulo'] = "Gerir Receitas";

        return $this->render('receitas/index.html.twig', $data);
    }

    /**
     * @Route("/receitas/add", name="add_receitas")
     * @IsGranted("ROLE_USER")
     */
    public function adicionar(Request $request, EntityManagerInterface $em): Response 
    {
        $msg = '';
        $receita = new Receitas();
        $form = $this->createForm(ReceitasType::class, $receita);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em->persist($receita);
            $em->flush();
            $msg = "Receita adicionada com sucesso!";
        }

        $data['titulo'] = 'Adicionar nova receita';
        $data['form'] = $form;
        $data['msg'] = $msg;

        return $this->renderForm('receitas/form.html.twig', $data);
    }

     /**
     * @Route("/receitas/edit/{id}", name="edit_receitas")
     * @IsGranted("ROLE_USER")
     */
    public function editar($id, Request $request, EntityManagerInterface $em, ReceitasRepository $receitasRepository): Response
    {
        $msg = '';
        $receita = $receitasRepository->find($id);
        $form = $this->createForm(ReceitasType::class, $receita);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em->flush();   
            $msg = 'Receita atualizada com sucesso!';
        }

        $data['titulo'] = 'Editar receita';
        $data['form'] = $form;
        $data['msg'] = $msg;

        return $this->renderForm('receitas/form.html.twig', $data);
    }

     /**
     * @Route("/receitas/delete/{id}", name="delete_receitas")
     * @IsGranted("ROLE_USER")
     */
    public function apagar($id, EntityManagerInterface $em, ReceitasRepository $receitasRepository): Response
    {
        $receita = $receitasRepository->find($id);
        
        $em->remove($receita);
        $em->flush();

        return $this->redirectToRoute('app_receitas');
    }
}
