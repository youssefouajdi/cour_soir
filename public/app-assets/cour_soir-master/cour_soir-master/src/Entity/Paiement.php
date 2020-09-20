<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Paiement
 *
 * @ORM\Table(name="paiement", indexes={@ORM\Index(name="test03", columns={"id_eleve"})})
 * @ORM\Entity(repositoryClass="App\Repository\PaiementRepository")
 */
class Paiement
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_paiement", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPaiement;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_paiement", type="date", nullable=false)
     */
    private $dtPaiement;

    /**
     * @var string
     *
     * @ORM\Column(name="mode", type="string", length=250, nullable=false)
     */
    private $mode;

    /**
     * @var int
     *
     * @ORM\Column(name="montant_total", type="integer", nullable=false)
     */
    private $montantTotal;

    /**
     * @var int
     *
     * @ORM\Column(name="motant_rest", type="integer", nullable=false)
     */
    private $motantRest;

    /**
     * @var \Eleve
     *
     * @ORM\ManyToOne(targetEntity="Eleve")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_eleve", referencedColumnName="id_eleve")
     * })
     */
    private $idEleve;

    public function getIdPaiement(): ?int
    {
        return $this->idPaiement;
    }

    public function getDtPaiement(): ?\DateTimeInterface
    {
        return $this->dtPaiement;
    }

    public function setDtPaiement(\DateTimeInterface $dtPaiement): self
    {
        $this->dtPaiement = $dtPaiement;

        return $this;
    }

    public function getMode(): ?string
    {
        return $this->mode;
    }

    public function setMode(string $mode): self
    {
        $this->mode = $mode;

        return $this;
    }

    public function getMontantTotal(): ?int
    {
        return $this->montantTotal;
    }

    public function setMontantTotal(int $montantTotal): self
    {
        $this->montantTotal = $montantTotal;

        return $this;
    }

    public function getMotantRest(): ?int
    {
        return $this->motantRest;
    }

    public function setMotantRest(int $motantRest): self
    {
        $this->motantRest = $motantRest;

        return $this;
    }

    public function getIdEleve(): ?Eleve
    {
        return $this->idEleve;
    }

    public function setIdEleve(?Eleve $idEleve): self
    {
        $this->idEleve = $idEleve;

        return $this;
    }


}
