<?php

namespace App\Repository;

use App\Entity\Opinion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Opinion>
 *
 * @method Opinion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Opinion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Opinion[]    findAll()
 * @method Opinion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OpinionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Opinion::class);
    }

    public function save(Opinion $opinion, bool $flush = false): void
    {
        $this->getEntityManager()->persist($opinion);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
