<?php

namespace App\Repository;

use App\Entity\Pattern;
use App\Model\SearchData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pattern>
 */
class PatternRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pattern::class);
    }

    public function search(SearchData $searchData): array
    {
        $qb = $this->createQueryBuilder('p');

        if (!empty($searchData->search)) {
            $qb->andWhere('p.title LIKE :search')
                ->setParameter('search', '%' . $searchData->search . '%');
        }

        return $qb->getQuery()->getResult();
    }


//    /**
//     * @return Pattern[] Returns an array of Pattern objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Pattern
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
