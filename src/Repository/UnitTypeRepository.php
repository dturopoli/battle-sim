<?php

namespace App\Repository;

use App\Entity\UnitType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UnitType>
 *
 * @method UnitType|null find($id, $lockMode = null, $lockVersion = null)
 * @method UnitType|null findOneBy(array $criteria, array $orderBy = null)
 * @method UnitType[]    findAll()
 * @method UnitType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UnitTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UnitType::class);
    }
}
