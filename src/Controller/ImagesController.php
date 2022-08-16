<?php

namespace App\Controller;

use App\Entity\Images;
use App\Form\ImagesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImagesController extends AbstractController
{
    /**
     * @Route("/images", name="app_images")
     */
    public function index(EntityManagerInterface $em): Response
    {
        $image = new Images();
        $image->setPath("a definir");
        $msg = "";

        try {
            $em->persist($image);
            $em->flush();
            $msg = "Imagem adicionada com sucesso";
        }
        catch(Exception $e) {
            $msg = "Erro ao criar imagem";
        }

        return new Response("<h1>" . $msg . "</h1>");
    }

    /**
     * @Route("/images/add", name="add_images")
     */
    public function adicionar(): Response
    {
        $form = $this->createForm(ImagesType::class);
        $data['titulo'] = 'Adicionar imagem';
        $data['form'] = $form;

        return $this->renderForm('images/form.html.twig', $data);
    }
}
