<?php

namespace App\Repository;

use App\Entity\Supplier;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * CommentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SupplierProductRepository extends EntityRepository
{

    public function findLast()
    {
        return $this
            ->createQueryBuilder("e")
            ->orderBy("e.id", "DESC")
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}