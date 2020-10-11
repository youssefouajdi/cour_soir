<?php

namespace App\Repository;

use App\Entity\Matiere;
use App\Entity\Professeur;
use App\Entity\ProfesseurSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Professeur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Professeur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Professeur[]    findAll()
 * @method Professeur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfesseurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Professeur::class);
    }

    /**
     * @return Professeur[]
     */
    public function findAllProf(ProfesseurSearch $search): ?array{
        $query=$this->findAll();
        $entityManager = $this->getEntityManager();
        if( $search->getNomProf() || $search->getPrenomProf() || $search->getModule()) {
            dd($search);
            if ($search->getPrenomProf()) {
                $query = $entityManager->createQuery(
                    'SELECT p
                FROM App\Entity\Professeur p
                    WHERE p.prenom = :prenomprof')
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
            }*/
            dd($search->getNomProf());
            return $query->getResult();
        }
    return $query;
    }

    /**
     * @param $value
     * @return \Doctrine\ORM\QueryBuilder Returns an array of Professeur objects
     */

    public function findByExampleField($value1,$value2)
    {
        dd( $this->createQueryBuilder('a')
             ->andWhere('a.nom_matiere LIKE :val')
            ->andWhere('a.niveau = :val2')
            ->setParameter('val', $value1)
            ->setParameter('val2', $value2)
            ->getQuery()
            ->execute());

    }

}
