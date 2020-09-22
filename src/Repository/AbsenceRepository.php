<?php

namespace App\Repository;

use App\Entity\Eleve;
use App\Entity\Absence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Absence|null find($id, $lockMode = null, $lockVersion = null)
 * @method Absence|null findOneBy(array $criteria, array $orderBy = null)
 * @method Absence[]    findAll()
 * @method Absence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbsenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Absence::class);
    }

/*
    public function findAllAbs(Absence $search): ?array{
        $query=$this->findAll();
        $entityManager = $this->getEntityManager();
        if( $search->getIdEleve() || $search->getIdSeance()) {
            if ($search->getIdEleve()) {
                $query = $entityManager->createQuery(
                    'SELECT p
                FROM App\Entity\Eleve p
                    WHERE p.niveau = :prenomprof')
                    ->setParameter('prenomprof', $search->getPrenomProf());
            }
            if ($search->getNomProf()) {
                $query = $entityManager->createQuery(
                    'SELECT p
                FROM App\Entity\Professeur p
                    WHERE p.nom = :nomprof')
                    ->setParameter('nomprof', $search->getNomProf());
            }
/*
            if ($search->getModule()) {
                $query = $entityManager->createQuery(
                    'SELECT p
                FROM App\Entity\Professeur p
                    WHERE p.idMatiere = :moduleprof')
                    ->setParameter('moduleprof', $search->getModule());
            }
            return $query->getResult();
        }
    return $query;
    }*/

    // /**
    //  * @return Absence[] Returns an array of Absence objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Absence
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
             ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}