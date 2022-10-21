<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Hardware;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Hardware>
 *
 * @method Hardware|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hardware|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hardware[]    findAll()
 * @method Hardware[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class HardwareRepository extends ServiceEntityRepository
{
    /**
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hardware::class);
    }

    /**
     *
     * @param Hardware $entity
     * @param bool $flush, default: true
     * @return void
     */
    public function save(Hardware $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     *
     * @param Hardware $entity
     * @param bool $flush, default: true
     * @return void
     */
    public function remove(Hardware $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
