<?php

namespace App\Repository;

use App\Contract\Model\SpecialEventInterface;
use App\Entity\SpecialEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SpecialEvent>
 *
 * @method SpecialEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method SpecialEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method SpecialEvent[]    findAll()
 * @method SpecialEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpecialEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SpecialEvent::class);
    }

    public function save(SpecialEvent $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SpecialEvent $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Get random special event
     * @return SpecialEventInterface|null
     */
    public function random(): ?SpecialEventInterface
    {
        $ids = $this->createQueryBuilder('se')
            ->select('se.id')
            ->getQuery()
            ->getResult();

        $ids = array_column($ids, 'id');

        if (!$ids) {
            return null;
        }

        return $this->find($ids[array_rand($ids)]);
    }
}
