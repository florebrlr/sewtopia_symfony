<?php

namespace App\Repository;

use App\Entity\Pattern;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class PatternRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $em;

    /**
     * @param EntityManagerInterface $em
     */

    public function __construct(ManagerRegistry $registry,EntityManagerInterface $em)
    {
        parent::__construct($registry, Pattern::class);
        $this->em = $em;
    }
    public function findBySearchData($searchData){
        //je réupère les données du formulaire
        $title = $searchData->getData()['searchByName'];
        $category = $searchData->getData()['category'];
        $author = $searchData->getData()['author'];
        $isRealized = $searchData->getData()['isRealized'];
        $isPrinted = $searchData->getData()['isPrinted'];
        $dateRealized = $searchData->getData()['dateRealized'];
        //on créé le querybuilder pour récupérer les patrons correspondant au filtre
        $builder = $this->em
            ->getRepository(Pattern::class)
            ->createQueryBuilder('pattern');


        if($title){
            $builder->andWhere('pattern.title LIKE :title')
                ->setParameter('title',"%".$title."%"); 
        }
        if($category){
            $builder->andWhere('pattern.category = :category')
                ->setParameter('category',$category);
        }
        if($author){
            $builder->andWhere('pattern.author LIKE :author')
                ->setParameter('author',"%".$author."%");
        }
        if($isRealized){
            $builder->andWhere('pattern.isRealized = :isRealized')
                ->setParameter('isRealized',$isRealized);
        }
        if($isPrinted){
            $builder->andWhere('pattern.isPrinted = :isPrinted')
                ->setParameter('isPrinted',$isPrinted);
        }
        if($dateRealized){
            $builder->andWhere('pattern.dateRealized LIKE :dateRealized')
                ->setParameter('dateRealized',$dateRealized);
        }


        return $builder->orderBy('pattern.dateRealized', 'ASC')->getQuery();
    }

}
