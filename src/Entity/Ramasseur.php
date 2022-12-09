<?php

namespace App\Entity;

use App\Repository\RamasseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RamasseurRepository::class)
 */
class Ramasseur
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\ManyToMany(targetEntity=Rencontre::class, inversedBy="ramasseurs")
     */
    private $rencontres;

    /**
     * @ORM\ManyToMany(targetEntity=Tournoi::class, mappedBy="ramasseurs")
     */
    private $tournois;

    public function __construct()
    {
        $this->rencontres = new ArrayCollection();
        $this->tournois = new ArrayCollection();
    }

    public function __toString() {
        return  $this->id . ' - ' . $this->nom . ' - ' . $this->prenom;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|Rencontre[]
     */
    public function getRencontres(): Collection
    {
        return $this->rencontres;
    }

    public function addRencontre(Rencontre $rencontre): self
    {
        if (!$this->rencontres->contains($rencontre)) {
            $this->rencontres[] = $rencontre;
        }

        return $this;
    }

    public function removeRencontre(Rencontre $rencontre): self
    {
        $this->rencontres->removeElement($rencontre);

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
            $tournoi->addRamasseur($this);
        }

        return $this;
    }

    public function removeTournoi(Tournoi $tournoi): self
    {
        if ($this->tournois->removeElement($tournoi)) {
            $tournoi->removeRamasseur($this);
        }

        return $this;
    }
}
