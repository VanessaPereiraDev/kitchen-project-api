<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ReceitasType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nome da receita: '])
            ->add('passo1', TextType::class, ['label' => 'Passo 1: '])
            ->add('passo2', TextType::class, ['label' => 'Passo 2: '])
            ->add('passo3', TextType::class, ['label' => 'Passo 3: '])
            ->add('passo4', TextType::class, ['label' => 'Passo 4: '])
            ->add('Salvar', SubmitType::class);
    }
}