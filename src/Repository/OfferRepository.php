<?php
// src/Repository/OfferRepository.php

namespace App\Repository;

use App\Entity\Offer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

class OfferRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offer::class);
    }

    // Exemple de mètode personalitzat
    public function findByCompany(string $company): array
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.company = :company')
            ->setParameter('company', $company)
            ->getQuery()
            ->getResult();
    }

    // src/Repository/PersonaRepository.php

    public function findAllIdAndCompany(): array
    {
        return $this->createQueryBuilder('p')
            ->select('p.id, p.company, p.role')
            ->getQuery()
            ->getArrayResult();
    }

    public function countOffersGroupedByDay(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT DATE(o.applied_at) as day, COUNT(*) as count
        FROM offer o
        GROUP BY day
        ORDER BY day ASC
    ';

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
