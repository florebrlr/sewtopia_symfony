<?php

namespace App\Form;

use App\Entity\Pattern;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PatternType extends AbstractType
{
public function buildForm(FormBuilderInterface $builder, array $options): void
{
    $builder
        ->add('title', TextType::class, [
            'label' => 'Nom du patron : ',
            'require' => true
        ])

        ->add('author', TextType::class, [
            'label' => 'Créatrice.teur. : '
        ])

        ->add('isPrinted', CheckboxType::class, [
            'required' => true,
            'label' => 'Patron imprimé ?'
        ])

        ->add('commentary', TextareaType::class, [
        'label' => 'Commentaire : ',
        'required' => false
        ]);
}
public function configureOptions(OptionsResolver $resolver): void
{
    $resolver->setDefaults([
        'data_class' => Pattern::class,
        'required' => false,
        'csrf_protection' => false
        ]);
}
}