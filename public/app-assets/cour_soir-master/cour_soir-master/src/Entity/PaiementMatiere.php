<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PaiementMatiere
 *
 * @ORM\Table(name="paiement_matiere", indexes={@ORM\Index(name="test25", columns={"id_matiere"}), @ORM\Index(name="test22", columns={"id_paiement"})})
 * @ORM\Entity
 */
class PaiementMatiere
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Paiement
     *
     * @ORM\ManyToOne(targetEntity="Paiement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_paiement", referencedColumnName="id_paiement")
     * })
     */
    private $idPaiement;

    /**
     * @var \Matiere
     *
     * @ORM\ManyToOne(targetEntity="Matiere")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_matiere", referencedColumnName="id_matiere")
     * })
     */
    private $idMatiere;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPaiement(): ?Paiement
    {
        return $this->idPaiement;
    }

    public function setIdPaiement(?Paiement $idPaiement): self
    {
        $this->idPaiement = $idPaiement;

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


}
