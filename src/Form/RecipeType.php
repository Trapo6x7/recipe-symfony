<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Recipe;
use DateTimeImmutable;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Form\Type\VichImageType;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('id', IntegerType::class)
            ->add(
                'name',
                TextType::class,
                [
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'label' => 'Nom de la recette:'
                ]
            )
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
            ->add('category', EntityType::class,        [
                'class' => Category::class,
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Category de la recette:'
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => true,
                'allow_delete' => true,
                'download_uri' => true, 
            ])
            ->add('createdAt', DateType::class)
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
