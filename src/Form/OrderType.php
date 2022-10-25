<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class , [
                'attr' => [
                    'class' => 'form__size form__select',
                    'maxlength' => 50
                ],
            ])
            ->add('email', TextType::class , [
                'attr' => [
                    'class' => 'form__size form__select checkout__email',
                    'maxlength' => 50
                ],
            ])
            ->add('adress', TextType::class , [
                'attr' => [
                    'class' => 'form__size form__select',
                    'maxlength' => 50
                ],
            ])
            ->add('postal', TextType::class , [
                    'attr' => [
                        'class' => 'form__size form__select',
                        'maxlength' => 6
                    ],
                ])
            ->add('paymethod', ChoiceType::class, [
                'choices' => [
                    'Contant' => 'Contant',
                    'IDEAL' => 'IDEAL',
                ],
                'attr' => [
                    'class' => 'form__size form__choice form__select',
                    'maxlength' => 6
                ],
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
