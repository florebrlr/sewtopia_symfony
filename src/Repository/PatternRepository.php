<?php
//
//namespace App\Repository;
//
//use App\Entity\Pattern;
//use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
//use Doctrine\ORM\EntityManagerInterface;
//use Doctrine\ORM\QueryBuilder;
//use Doctrine\Persistence\ManagerRegistry;
//
//class PatternRepository extends ServiceEntityRepository
//{
//    private EntityManagerInterface $em;
//
//    /**
//     * @param EntityManagerInterface $em
//     */
//
//    public function __construct(ManagerRegistry $registry,EntityManagerInterface $em)
//    {
//        parent::__construct($registry, Pattern::class);
//        $this->em = $em;
//    }
//    public function findBySearchData($searchData){
//        //je réupère les données du formulaire
//        $title = $searchData->getData()['searchByName'];
//        $category = $searchData->getData()['category'];
//        $author = $searchData->getData()['author'];
//        $isRealized = $searchData->getData()['isRealized'];
//        $isPrinted = $searchData->getData()['isPrinted'];
//        $dateRealized = $searchData->getData()['dateRealized'];
//        //on créé le querybuilder pour récupérer les patrons correspondant au filtre
//        $builder = $this->em
//            ->getRepository(Pattern::class)
//            ->createQueryBuilder('pattern');
//
//
//        if($title){
//            $builder->andWhere('pattern.title LIKE :title')
//                ->setParameter('title',"%".$title."%");
//        }
//        if($category){
//            $builder->andWhere('pattern.category = :category')
//                ->setParameter('category',$category);
//        }
//        if($author){
//            $builder->andWhere('pattern.author LIKE :author')
//                ->setParameter('author',"%".$author."%");
//        }
//        if($isRealized){
//            $builder->andWhere('pattern.isRealized = :isRealized')
//                ->setParameter('isRealized',$isRealized);
//        }
//        if($isPrinted){
//            $builder->andWhere('pattern.isPrinted = :isPrinted')
//                ->setParameter('isPrinted',$isPrinted);
//        }
//        if($dateRealized){
//            $builder->andWhere('pattern.dateRealized LIKE :dateRealized')
//                ->setParameter('dateRealized',$dateRealized);
//        }
//
//
//        return $builder->orderBy('pattern.dateRealized', 'ASC')->getQuery();
//    }
//
//}
//

namespace App\Repository;

use App\Entity\Pattern;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class PatternRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $em;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        parent::__construct($registry, Pattern::class);
        $this->em = $em;
    }

    /**
     * @param array $data Les données du formulaire de recherche
     * @return QueryBuilder
     */
    public function findBySearchData(array $data): QueryBuilder
    {
        $qb = $this->createQueryBuilder('pattern');

        if (!empty($data['searchByName'])) {
            $qb->andWhere('pattern.title LIKE :title')
                ->setParameter('title', '%' . $data['searchByName'] . '%');
        }

        if (!empty($data['category'])) {
            $qb->andWhere('pattern.category = :category')
                ->setParameter('category', $data['category']);
        }

        if (!empty($data['author'])) {
            $qb->andWhere('pattern.author LIKE :author')
                ->setParameter('author', '%' . $data['author'] . '%');
        }

        if (!is_null($data['isRealized'])) {
            $qb->andWhere('pattern.isRealized = :isRealized')
                ->setParameter('isRealized', $data['isRealized']);
        }

        if (!is_null($data['isPrinted'])) {
            $qb->andWhere('pattern.isPrinted = :isPrinted')
                ->setParameter('isPrinted', $data['isPrinted']);
        }

        if (!empty($data['dateRealized'])) {
            $qb->andWhere('pattern.dateRealized LIKE :dateRealized')
                ->setParameter('dateRealized', $data['dateRealized']);
        }

        return $qb->orderBy('pattern.dateRealized', 'ASC');
    }
}

