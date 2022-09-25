<?php

namespace App\Repository;

use App\Contract\Model\TerrainInterface;
use App\Entity\Terrain;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Terrain>
 *
 * @method Terrain|null find($id, $lockMode = null, $lockVersion = null)
 * @method Terrain|null findOneBy(array $criteria, array $orderBy = null)
 * @method Terrain[]    findAll()
 * @method Terrain[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TerrainRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Terrain::class);
    }

    /**
     * Get random terrain
     * @return TerrainInterface|null
     */
    public function random(): ?TerrainInterface
    {
        $ids = $this->createQueryBuilder('t')
            ->select('t.id')
            ->getQuery()
            ->getResult();

        $ids = array_column($ids, 'id');

        if (!$ids) {
            return null;
        }

        return $this->find($ids[array_rand($ids)]);
    }
}
