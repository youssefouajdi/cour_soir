<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Seance
 *
 * @ORM\Table(name="seance", indexes={@ORM\Index(name="test", columns={"id_matiere"}), @ORM\Index(name="test123", columns={"id_professeur"})})
 * @ORM\Entity(repositoryClass="App\Repository\SeanceRepository")
 */
class Seance
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_seance", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSeance;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dtdebut", type="date", nullable=false)
     */
    private $dtdebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dtfin", type="date", nullable=false)
     */
    private $dtfin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="h_debut", type="time", nullable=false)
     */
    private $hDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="h_fin", type="time", nullable=false)
     */
    private $hFin;

    /**
     * @var int
     *
     * @ORM\Column(name="salle", type="integer", nullable=false)
     */
    private $salle;

    /**
     * @var bool
     *
     * @ORM\Column(name="effectuer", type="boolean", nullable=false)
     */
    private $effectuer;

    /**
     * @var \Matiere
     *
     * @ORM\ManyToOne(targetEntity="Matiere")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_matiere", referencedColumnName="id_matiere")
     * })
     */
    private $idMatiere;

    /**
     * @var \Professeur
     *
     * @ORM\ManyToOne(targetEntity="Professeur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_professeur", referencedColumnName="id")
     * })
     */
    private $idProfesseur;

    /**
     * @ORM\Column(type="date")
     */
    private $Jour;

    public function getIdSeance(): ?int
    {
        return $this->idSeance;
    }

    public function getDtdebut(): ?\DateTimeInterface
    {
        return $this->dtdebut;
    }

    public function setDtdebut(\DateTimeInterface $dtdebut): self
    {
        $this->dtdebut = $dtdebut;

        return $this;
    }

    public function getDtfin(): ?\DateTimeInterface
    {
        return $this->dtfin;
    }

    public function setDtfin(\DateTimeInterface $dtfin): self
    {
        $this->dtfin = $dtfin;

        return $this;
    }


    public function getHDebut(): ?\DateTimeInterface
    {
        return $this->hDebut;
    }

    public function setHDebut(\DateTimeInterface $hDebut): self
    {
        $this->hDebut = $hDebut;

        return $this;
    }

    public function getHFin(): ?\DateTimeInterface
    {
        return $this->hFin;
    }

    public function setHFin(\DateTimeInterface $hFin): self
    {
        $this->hFin = $hFin;

        return $this;
    }

    public function getSalle(): ?int
    {
        return $this->salle;
    }

    public function setSalle(int $salle): self
    {
        $this->salle = $salle;

        return $this;
    }

    public function getEffectuer(): ?bool
    {
        return $this->effectuer;
    }

    public function setEffectuer(bool $effectuer): self
    {
        $this->effectuer = $effectuer;

        return $this;
    }

    public function getIdMatiere(): ?Matiere
    {
        return $this->idMatiere;
    }

    public function setIdMatiere(?Matiere $idMatiere): self
    {
        $this->idMatiere = $idMatiere;

        return $this;
    }

    public function getIdProfesseur(): ?Professeur
    {
        return $this->idProfesseur;
    }

    public function setIdProfesseur(?Professeur $idProfesseur): self
    {
        $this->idProfesseur = $idProfesseur;

        return $this;
    }

    public function getJour(): ?\DateTimeInterface
    {
        return $this->Jour;
    }

    public function setJour(\DateTimeInterface $Jour): self
    {
        $this->Jour = $Jour;

        return $this;
    }


}
