<?php

namespace App\Repository;

use App\Entity\Virement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Virement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Virement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Virement[]    findAll()
 * @method Virement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VirementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Virement::class);
    }

    // /**
    //  * @return Virement[] Returns an array of Virement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Virement
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
