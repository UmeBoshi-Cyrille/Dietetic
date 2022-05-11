<?php

namespace App\Form;

use App\Entity\Allergene;
use App\Entity\Ingredient;
use App\Entity\Recette;
use App\Entity\Regime;
use App\Repository\AllergeneRepository;
use App\Repository\IngredientRepository;
use App\Repository\RegimeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class RecetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '255'
                ],
                'label' => 'Nom',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 255]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Description',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
            ->add('regimes', EntityType::class, [
                'attr' => [
                    'class' => 'form-check'
                ],
                'class' => Regime::class,
                'query_builder' => function (RegimeRepository $rr) {
                    return $rr->createQueryBuilder('n')
                        ->orderBy('n.name', 'ASC');
                },
                'label' => 'Les régimes',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('allergenes', EntityType::class, [
                'class' => Allergene::class,
                'query_builder' => function (AllergeneRepository $ar) {
                    return $ar->createQueryBuilder('n')
                        ->orderBy('n.name', 'ASC');
                },
                'label' => 'Les allergènes',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('preparationTime', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'min' => '1',
                    'max' => '90'
                ],
                'label' => 'Temps de préparation',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Positive(),
                    new Assert\LessThan(90)
                ]
            ])
            ->add('restTime', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'min' => '1',
                    'max' => '90'
                ],
                'label' => 'Temps de repos',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Positive(),
                    new Assert\LessThan(90),
                ]
            ])
            ->add('cookingTime', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'min' => '1',
                    'max' => '90'
                ],
                'label' => 'Temps de cuisson',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Positive(),
                    new Assert\LessThan(90),
                ]
            ])
            ->add('ingredients', EntityType::class, [
                'class' => Ingredient::class,
                'query_builder' => function (IngredientRepository $ir) {
                    return $ir->createQueryBuilder('n')
                        ->orderBy('n.name', 'ASC');
                },
                'label' => 'Les ingrédients',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('step', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Les étapes',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\NotNull()
                ]
            ])
            ->add('isPublished', CheckboxType::class, [
                'attr' => [
                    'class' => 'form-check-input'
                ],
                'label' => 'Rendre public ?',
                'label_attr' => [
                    'class' => 'form-check-label'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4 mb-4'
                ],
                'label' => 'Ajouter'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recette::class,
        ]);
    }
}
