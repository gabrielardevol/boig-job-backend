<?php
// src/Repository/OfferRepository.php

namespace App\Repository;

use App\Entity\Offer;
use App\Entity\OfferResponse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

class OfferResponseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OfferResponse::class);
    }

    public function countGroupedByDay(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT DATE(o.created_at) as day, COUNT(*) as count
        FROM offer_response o
        WHERE o.type = 'interview' OR o.type = 'assignment'
        GROUP BY day
        ORDER BY day ASC"
       ;

        $stmt = $conn->executeQuery($sql);

        return array_map(function ($row) {
            return [
                'day' => new \DateTimeImmutable($row['day']),
                'count' => (int) $row['count'],
            ];
        }, $stmt->fetchAllAssociative());
    }
//    public function findAllByAttribute(string $attribute, int $page = 1, int $limit = 30)
//    {
//        $query = $this->createQueryBuilder('p')
//            ->orderBy('p.' . $attribute, 'ASC')
//            ->setFirstResult(($page - 1) * $limit)
//            ->setMaxResults($limit)
//            ->getQuery();
//
//        return new Paginator($query);
//    }


}
