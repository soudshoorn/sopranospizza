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
                    '15cm (Small)' => 15,
                    '30cm (Medium)' => 30,
                    '40cm (Large)' => 40,
                ],
            ])
            ->add('topping', ChoiceType::class, [
                'choices'  => [
                    'Knoflook Saus' => 'knoflook',
                    'Sambal' => 'sambal',
                    'Chilli Saus' => 'chilli',
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
