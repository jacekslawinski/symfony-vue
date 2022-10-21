<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Hardware;
use App\Entity\UserHardware;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserHardware>
 *
 * @method UserHardware|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserHardware|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserHardware[]    findAll()
 * @method UserHardware[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserHardwareRepository extends ServiceEntityRepository
{
    /**
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserHardware::class);
    }

    /**
     *
     * @param UserHardware $entity
     * @param bool $flush, default: false
     * @return void
     */
    public function save(UserHardware $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     *
     * @param UserHardware $entity
     * @param bool $flush, default: false
     * @return void
     */
    public function remove(UserHardware $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     *
     * @param Hardware $hardware
     * @return void
     */
    public function removeBy(Hardware $hardware): void
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->delete(UserHardware::class, 'uh')
            ->where('uh.hardware = :hardware')
            ->setParameter('hardware', $hardware)
            ->getQuery()
            ->execute();
    }
}
