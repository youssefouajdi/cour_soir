<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Matiere
 *
 * @ORM\Table(name="matiere")
 * @ORM\Entity(repositoryClass="App\Repository\MatiereRepository")
 */
class Matiere
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_matiere", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMatiere;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_matiere", type="string", length=250, nullable=false)
     */
    private $nomMatiere;

    /**
     * @var string
     *
     * @ORM\Column(name="niveau", type="string", nullable=false)
     */
    private $niveau;

    /**
     * @var int
     *
     * @ORM\Column(name="prix", type="integer", nullable=false)
     */
    private $prix;

    /**
     * @ORM\OneToMany(targetEntity=Affectation::class, mappedBy="id_matiere")
     */
    private $affectations;

    public function __construct()
    {
        $this->affectations = new ArrayCollection();
    }

    public function getIdMatiere(): ?int
    {
        return $this->idMatiere;
    }

    public function getNomMatiere(): ?string
    {
        return $this->nomMatiere;
    }

    public function setNomMatiere(string $nomMatiere): self
    {
        $this->nomMatiere = $nomMatiere;

        return $this;
    }

    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(string $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }
    public function __toString()
    {
        return $this->getNiveau().' '.$this->getNomMatiere();
    }

    /**
     * @return Collection|Affectation[]
     */
    public function getAffectations(): Collection
    {
        return $this->affectations;
    }

    public function addAffectation(Affectation $affectation): self
    {
        if (!$this->affectations->contains($affectation)) {
            $this->affectations[] = $affectation;
            $affectation->setIdMatiere($this);
        }

        return $this;
    }

    public function removeAffectation(Affectation $affectation): self
    {
        if ($this->affectations->contains($affectation)) {
            $this->affectations->removeElement($affectation);
            // set the owning side to null (unless already changed)
            if ($affectation->getIdMatiere() === $this) {
                $affectation->setIdMatiere(null);
            }
        }

        return $this;
    }


}
