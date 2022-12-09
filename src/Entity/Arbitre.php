<?php

namespace App\Entity;

use App\Repository\ArbitreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArbitreRepository::class)
 */
class Arbitre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nationnalite;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $qualification;

    /**
     * @ORM\ManyToMany(targetEntity=Tournoi::class, mappedBy="arbitres")
     */
    private $tournois;

    /**
     * @ORM\ManyToMany(targetEntity=Rencontre::class, mappedBy="arbitres")
     */
    private $rencontre;

    public function __construct()
    {
        $this->tournois = new ArrayCollection();
        $this->r = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->id . ' - ' . $this->nom . ' - ' . $this->prenom . ' - ' . $this->qualification;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getNationnalite(): ?string
    {
        return $this->nationnalite;
    }

    public function setNationnalite(string $nationnalite): self
    {
        $this->nationnalite = $nationnalite;

        return $this;
    }

    public function getQualification(): ?string
    {
        return $this->qualification;
    }

    public function setQualification(string $qualification): self
    {
        $this->qualification = $qualification;

        return $this;
    }

    /**
     * @return Collection|Tournoi[]
     */
    public function getTournois(): Collection
    {
        return $this->tournois;
    }

    public function addTournoi(Tournoi $tournoi): self
    {
        if (!$this->tournois->contains($tournoi)) {
            $this->tournois[] = $tournoi;
            $tournoi->addArbitre($this);
        }

        return $this;
    }

    public function removeTournoi(Tournoi $tournoi): self
    {
        if ($this->tournois->removeElement($tournoi)) {
            $tournoi->removeArbitre($this);
        }

        return $this;
    }

    /**
     * @return Collection|Rencontre[]
     */
    public function getRencontre(): Collection
    {
        return $this->rencontre;
    }

    public function addR(Rencontre $rencontre): self
    {
        if (!$this->rencontre->contains($rencontre)) {
            $this->rencontre[] = $rencontre;
            $rencontre->addArbitre($this);
        }

        return $this;
    }

    public function removeRencontre(Rencontre $rencontre): self
    {
        if ($this->rencontre->removeElement($rencontre)) {
            $rencontre->removeArbitre($this);
        }

        return $this;
    }
}
