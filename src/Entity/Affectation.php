<?php

namespace App\Entity;

use App\Repository\AffectationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AffectationRepository::class)
 */
class Affectation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Eleve::class, inversedBy="affectations")
     * @ORM\JoinColumn(name="id_eleve", referencedColumnName="id_eleve")
     */
    private $id_eleve;

    /**
     * @ORM\ManyToOne(targetEntity=Matiere::class, inversedBy="affectations")
     * @ORM\JoinColumn(name="id_matiere", referencedColumnName="id_matiere")
     */
    private $id_matiere;

    /**
     * @ORM\Column(type="date")
     */
    private $jour;

    /**
     * @ORM\Column(type="integer")
     */
    private $paye;

    /**
     * @ORM\Column(type="integer")
     */
    private $reste;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdEleve(): ?Eleve
    {
        return $this->id_eleve;
    }

    public function setIdEleve(?Eleve $id_eleve): self
    {
        $this->id_eleve = $id_eleve;

        return $this;
    }

    public function getIdMatiere(): ?Matiere
    {
        return $this->id_matiere;
    }

    public function setIdMatiere(?Matiere $id_matiere): self
    {
        $this->id_matiere = $id_matiere;

        return $this;
    }

    public function getJour(): ?\DateTimeInterface
    {
        return $this->jour;
    }

    public function setJour(\DateTimeInterface $jour): self
    {
        $this->jour = $jour;

        return $this;
    }

    public function getPaye(): ?int
    {
        return $this->paye;
    }

    public function setPaye(int $paye): self
    {
        $this->paye = $paye;

        return $this;
    }

    public function getReste(): ?int
    {
        return $this->reste;
    }

    public function setReste(int $reste): self
    {
        $this->reste = $reste;

        return $this;
    }

    /**
     * @param $nom
     * @return Matiere[]
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findProf($nom): array
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('
        SELECT p.idMatiere FROM App\Entity\Matiere p
        WHERE p.nomMatiere = :nom ')->setParameter('nom', $nom);
        dd( $query->getResult());
    }
}
