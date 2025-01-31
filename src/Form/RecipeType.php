<?php

namespace App\Form;

use App\Entity\Recipe;
use DateTimeImmutable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
              // ->add('id', IntegerType::class)
              ->add('name', TextType::class,
              [
                  'attr' => [
                      'class' => 'form-control'
                  ],
                  'label' => 'Nom de la recette:'
              ])
              ->add('slug', TextType::class,         [
                  'attr' => [
                      'class' => 'form-control'
                  ],
                  'label' => 'Slug de la recette:'
              ])
              ->add('description', TextType::class,         [
                  'attr' => [
                      'class' => 'form-control'
                  ],
                  'label' => 'Description:'
              ])
              ->add('createdAt', DateType::class)
              ->add('submit', SubmitType::class)
          ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
