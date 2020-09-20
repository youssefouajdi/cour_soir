<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Virement
 *
 * @ORM\Table(name="virement", indexes={@ORM\Index(name="test45", columns={"id_prof"}), @ORM\Index(name="test56", columns={"id_personnel"})})
 * @ORM\Entity(repositoryClass="App\Repository\VirementRepository")
 */
class Virement
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_virement", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idVirement;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_virement", type="date", nullable=false)
     */
    private $dtVirement;

    /**
     * @var int
     *
     * @ORM\Column(name="total_salaire", type="integer", nullable=false)
     */
    private $totalSalaire;

    /**
     * @var int
     *
     * @ORM\Column(name="reste", type="integer", nullable=false)
     */
    private $reste;

    /**
     * @var \Professeur
     *
     * @ORM\ManyToOne(targetEntity="Professeur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_prof", referencedColumnName="id")
     * })
     */
    private $idProf;

    /**
     * @var \Personnel
     *
     * @ORM\ManyToOne(targetEntity="Personnel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_personnel", referencedColumnName="id_personnel")
     * })
     */
    private $idPersonnel;

    public function getIdVirement(): ?int
    {
        return $this->idVirement;
    }

    public function getDtVirement(): ?\DateTimeInterface
    {
        return $this->dtVirement;
    }

    public function setDtVirement(\DateTimeInterface $dtVirement): self
    {
        $this->dtVirement = $dtVirement;

        return $this;
    }

    public function getTotalSalaire(): ?int
    {
        return $this->totalSalaire;
    }

    public function setTotalSalaire(int $totalSalaire): self
    {
        $this->totalSalaire = $totalSalaire;

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

    public function getIdProf(): ?Professeur
    {
        return $this->idProf;
    }

    public function setIdProf(?Professeur $idProf): self
    {
        $this->idProf = $idProf;

        return $this;
    }

    public function getIdPersonnel(): ?Personnel
    {
        return $this->idPersonnel;
    }

    public function setIdPersonnel(?Personnel $idPersonnel): self
    {
        $this->idPersonnel = $idPersonnel;

        return $this;
    }


}
