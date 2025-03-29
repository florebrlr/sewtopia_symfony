<?php
// src/Form/CalculatorFormType.php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalculatorFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tour_de_taille', NumberType::class, [
                'label' => 'Tour de taille (en cm) : ',
                'attr' => ['class' => 'form-control']
            ])
            ->add('longueur_jupe', NumberType::class, [
                'label' => 'Longueur de la jupe (en cm) : ',
                'attr' => ['class' => 'form-control']
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}

