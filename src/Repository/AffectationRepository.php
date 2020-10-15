<?php

namespace App\Repository;

use App\Entity\Affectation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Affectation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Affectation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Affectation[]    findAll()
 * @method Affectation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AffectationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Affectation::class);
    }

     /**
     * @return Affectation[] Returns an array of Affectation objects
     */
    
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.id_eleve = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    

    public function findOneBySomeField($value)
    {
        $value=1;
        dd($this->createQueryBuilder('a')
            ->andWhere('a.id_eleve = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getArrayResult()
        );
    }

    public function createAlphabeticalQueryBuilder($price)
    {


        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT p.nom,p.prenom
            FROM App\Entity\Eleve p 
            WHERE p.idEleve LIKE :price'
        )->setParameter('price', $price);
        return  $query->getResult();

    }


}
