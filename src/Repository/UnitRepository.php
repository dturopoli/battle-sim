<?php

namespace App\Repository;

use App\Contract\Model\UnitInterface;
use App\Entity\Unit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Unit>
 *
 * @method Unit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Unit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Unit[]    findAll()
 * @method Unit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UnitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Unit::class);
    }

    /**
     * Get random unit for given unit type
     * @param string $type
     * @return UnitInterface|null
     */
    public function randomUnitOfType(string $type): ?UnitInterface
    {
        $ids = $this->createQueryBuilder('u')
            ->select('u.id')
            ->leftJoin('u.unitType', 'ut')
            ->andWhere('ut.name = :unit_type')
            ->setParameters([
                'unit_type' => $type,
            ])
            ->getQuery()
            ->getResult();

        $ids = array_column($ids, 'id');

        if (!$ids) {
            return null;
        }

        return $this->find($ids[array_rand($ids)]);
    }
}
