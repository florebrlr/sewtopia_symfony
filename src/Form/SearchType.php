<?php

namespace App\Form;

use App\Entity\Category;
use App\Model\SearchData;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('searchByName', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Rechercher un patron'
                ]
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'label' => 'Catégorie',
                'required' => false,
                'placeholder' => 'Toutes les catégories',
                'choice_label' => 'name'
            ])
            ->add('author', TextType::class, [
                'label' => 'Créateur·trice',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Nom du créateur·trice'
                ]
            ])
            ->add('isRealized', CheckboxType::class, [
                'label' => 'Patron réalisé',
                'required' => false
            ])
            ->add('isPrinted', CheckboxType::class, [
                'label' => 'Patron imprimé',
                'required' => false
            ])
            ->add('dateRealized', DateType::class, [
                'label' => 'Date de réalisation',
                'required' => false,
                'widget' => 'single_text',
                'html5' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }
}