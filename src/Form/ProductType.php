<?php 

namespace App\Form;

use App\Entity\Category;
use App\Entity\Images;
use App\Entity\Receitas;
use App\Entity\Ingredients;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ProductType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nome do produto: '])
            ->add('price', TextType::class, ['label' => 'Preço: '])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => 'Categoria: '
            ])
            ->add('image', EntityType::class, [
                'class' => Images::class,
                'choice_label' => 'path',
                'label' => 'Imagem: '
            ])
            ->add('ingredients', EntityType::class, [
                'class' => Ingredients::class,
                'choice_label' => 'description',
                'label' => 'Ingredientes: '
            ])
            ->add('receitas', EntityType::class, [
                'class' => Receitas::class,
                'choice_label' => 'name',
                'label' => 'Receita: '
            ])
            ->add('Salvar', SubmitType::class);   
    }
}