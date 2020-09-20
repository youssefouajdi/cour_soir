<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;

/**
 * Eleve
 *
 * @ORM\Table(name="eleve")
 * @ORM\Entity(repositoryClass="App\Repository\EleveRepository")
 */
class Eleve
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_eleve", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEleve;

    /**
     * @var string
     *
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
     * @var bool
     *
     * @ORM\Column(name="transport", type="boolean", nullable=false)
     */
    private $transport;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dt_inscription", type="date", nullable=false)
     */
    private $dtInscription ;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=250, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=250, nullable=false)
     */
    private $tel;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=30, nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="niveau", type="string", length=30, nullable=true)
     */
    private $niveau;

    /**
     * @ORM\OneToMany(targetEntity=Affectation::class, mappedBy="id_eleve")
     */
    private $affectations;

    public function __construct()
    {
        $this->affectations = new ArrayCollection();
    }

    public function getIdEleve(): ?int
    {
        return $this->idEleve;
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

    public function getTransport(): ?bool
    {
        return $this->transport;
    }

    public function setTransport(bool $transport): self
    {
        $this->transport = $transport;

        return $this;
    }

    public function getDtInscription(): ?\DateTimeInterface
    {
        return $this->dtInscription;
    }

    public function setDtInscription(\DateTimeInterface $dtInscription): self
    {
        $this->dtInscription = $dtInscription;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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
            $affectation->setIdEleve($this);
        }

        return $this;
    }

    public function removeAffectation(Affectation $affectation): self
    {
        if ($this->affectations->contains($affectation)) {
            $this->affectations->removeElement($affectation);
            // set the owning side to null (unless already changed)
            if ($affectation->getIdEleve() === $this) {
                $affectation->setIdEleve(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return (string)$this->getIdEleve();
    }
}
