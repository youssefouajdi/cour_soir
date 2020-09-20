<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Personnel
 *
 * @ORM\Table(name="personnel")
 * @ORM\Entity(repositoryClass="App\Repository\PersonnelRepository")
 */
class Personnel
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_personnel", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPersonnel;

    /**
     * @var string
     *a
     * @ORM\Column(name="nom", type="string", length=250, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=250, nullable=false)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="fonctionnalite", type="string", length=250, nullable=false)
     */
    private $fonctionnalite;

    /**
     * @var int
     *
     * @ORM\Column(name="salaire", type="integer", nullable=false)
     */
    private $salaire;

    public function getIdPersonnel(): ?int
    {
        return $this->idPersonnel;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getFonctionnalite(): ?string
    {
        return $this->fonctionnalite;
    }

    public function setFonctionnalite(string $fonctionnalite): self
    {
        $this->fonctionnalite = $fonctionnalite;

        return $this;
    }

    public function getSalaire(): ?int
    {
        return $this->salaire;
    }

    public function setSalaire(int $salaire): self
    {
        $this->salaire = $salaire;

        return $this;
    }


}
