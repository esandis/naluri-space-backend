<?php

namespace App\Repository;

use App\Entity\PiIteration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PiIteration|null find($id, $lockMode = null, $lockVersion = null)
 * @method PiIteration|null findOneBy(array $criteria, array $orderBy = null)
 * @method PiIteration[]    findAll()
 * @method PiIteration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PiIterationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PiIteration::class);
    }

    public function findByLatestIteration()
    {
        return $this->createQueryBuilder('piiteration')
            ->orderBy('piiteration.digit', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

}
