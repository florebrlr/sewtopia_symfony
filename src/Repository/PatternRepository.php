<?php

namespace App\Repository;

use App\Entity\Pattern;
use App\Model\SearchData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class PatternRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pattern::class);
    }

    public function getSearchQuery(SearchData $search): QueryBuilder
    {
        $qb = $this->createQueryBuilder('p');

// Ajoutez ici des conditions de filtrage basées sur les données de recherche
        $qb = $this->createQueryBuilder('p');

        if ($search->getSearch()) {
            $qb->andWhere('p.name LIKE :search')
                ->setParameter('search', '%' . $search->getSearch() . '%');
        }

        return $qb;
    }
}
