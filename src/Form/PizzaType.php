<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PizzaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('size', ChoiceType::class, [
                'choices'  => [
                    '25cm (Medium)' => '25cm (Medium)',
                    '35cm (Large)' => '35cm (Large)',
                    'Calzone' => 'Calzone',
                ],
                'attr' => [
                    'class' => 'form__size form__select'
                ],
            ])
            ->add('topping', ChoiceType::class, [
                'choices'  => [
                    'Knoflook Saus' => 'Knoflook Saus',
                    'Sambal' => 'Sambal',
                    'Chilli Flakes' => 'Chilli Flakes',
                ],
                'attr' => [
                    'class' => 'form__topping form__select'
                ],
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
