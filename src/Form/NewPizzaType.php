<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Pizza;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class NewPizzaType extends AbstractType
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
            ->add('description', TextType::class , [
                'attr' => [
                    'class' => 'form__size form__select',
                ],
            ])
            ->add('price', TextType::class , [
                'attr' => [
                    'class' => 'form__size form__select',
                ],
            ])
            ->add('category_id', ChoiceType::class, [
                'choices'  => [
                    '1 - Vlees' => 1,
                    '3 - Vegan' => 3,
                    '5 - Vis' => 5,
                ],
                'required' => false,
                'attr' => [
                    'class' => 'form__topping form__select new__pizza'
                ],
            ])
            ->add('img', FileType::class, [
                'label' => 'Pizza Image',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => 'form__topping form__select new__pizza'
                ],
                'constraints' => [
                    new File([
                        'maxSize' => '8192k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid Image',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pizza::class,
        ]);
    }
}
