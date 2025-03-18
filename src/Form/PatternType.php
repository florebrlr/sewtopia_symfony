<?php

namespace App\Form;

//use App\Entity\Category;
use App\Entity\Pattern;
//use App\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PatternType extends AbstractType
{
public function buildForm(FormBuilderInterface $builder, array $options): void
{
    $builder
        ->add('title', TextType::class, [
            'label' => 'Nom du patron : ',
            'required' => true
        ])

        ->add('author', TextType::class, [
            'label' => 'Créatrice.teur. : ',
            'required' => true
        ])

        ->add('isPrinted', CheckboxType::class, [
            'required' => false,
            'label' => 'Patron imprimé'
        ])
        ->add('dateProduced', DateType::class, [
            'required' => false,
            'label' => 'Date de réalisation'
        ])

        ->add('commentary', TextareaType::class, [
        'label' => 'Commentaire : ',
        'required' => false
        ]);

//        ->add('category', EntityType::class, [
//        'class' => Category::class,
//        'query_builder' => function (CategoryRepository $categoryRepository) {
//            return $categoryRepository->findCategoriesOrderBy();
//        }
//    ]);
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