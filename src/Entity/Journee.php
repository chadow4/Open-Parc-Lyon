<?php

namespace App\Entity;

use App\Repository\JourneeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=JourneeRepository::class)
 */
class Journee
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string")
     */
    private $type_court;

    /**
     * @ORM\OneToMany(targetEntity=Rencontre::class, mappedBy="journee")
     */
    private $rencontres;

    /**
     * @ORM\ManyToOne(targetEntity=Tournoi::class, inversedBy="journees")
     */
    private $tournoi;

    /**
     * @ORM\OneToMany(targetEntity=Billet::class, mappedBy="journee")
     */
    private $billets;

    /**
     * @ORM\Column(type="integer")
     */
    private $billet_gradin_haut;

    /**
     * @ORM\Column(type="integer")
     */
    private $billet_gradin_bas;

    /**
     * @ORM\Column(type="integer")
     */
    private $billet_loge;

    public function __construct()
    {
        $this->rencontres = new ArrayCollection();
        $this->billets = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->date->format('d-m-Y'). ' - ' . $this->type_court;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTypeCourt(): ?String
    {
        return $this->type_court;
    }

    public function setTypeCourt(?String $type_court): self
    {
        $this->type_court = $type_court;

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
            $rencontre->setJournee($this);
        }

        return $this;
    }

    public function removeRencontre(Rencontre $rencontre): self
    {
        if ($this->rencontres->removeElement($rencontre)) {
            // set the owning side to null (unless already changed)
            if ($rencontre->getJournee() === $this) {
                $rencontre->setJournee(null);
            }
        }

        return $this;
    }

    public function getTournoi(): ?Tournoi
    {
        return $this->tournoi;
    }

    public function setTournoi(?Tournoi $tournoi): self
    {
        $this->tournoi = $tournoi;

        return $this;
    }

    /**
     * @return Collection|Billet[]
     */
    public function getBillets(): Collection
    {
        return $this->billets;
    }

    public function addBillet(Billet $billet): self
    {
        if (!$this->billets->contains($billet)) {
            $this->billets[] = $billet;
            $billet->setJournee($this);
        }

        return $this;
    }

    public function removeBillet(Billet $billet): self
    {
        if ($this->billets->removeElement($billet)) {
            // set the owning side to null (unless already changed)
            if ($billet->getJournee() === $this) {
                $billet->setJournee(null);
            }
        }

        return $this;
    }


    public function getBilletGradinHaut(): ?int
    {
        return $this->billet_gradin_haut;
    }

    public function setBilletGradinHaut(int $billet_gradin_haut): self
    {
        $this->billet_gradin_haut = $billet_gradin_haut;

        return $this;
    }

    public function getBilletGradinBas(): ?int
    {
        return $this->billet_gradin_bas;
    }

    public function setBilletGradinBas(int $billet_gradin_bas): self
    {
        $this->billet_gradin_bas = $billet_gradin_bas;

        return $this;
    }

    public function getBilletLoge(): ?int
    {
        return $this->billet_loge;
    }

    public function setBilletLoge(int $billet_loge): self
    {
        $this->billet_loge = $billet_loge;

        return $this;
    }
}
