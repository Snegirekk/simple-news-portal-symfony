<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

abstract class BaseEntityRepository extends ServiceEntityRepository
{
    /**
     * BaseEntityRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, $this->getEntityClass());
    }

    /**
     * @return string
     */
    abstract protected function getEntityClass(): string;
}