<?php

namespace App\Entity;

use App\Repository\RencontreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RencontreRepository::class)
 */
class Rencontre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Equipe::class, inversedBy="rencontres")
     */
    private $equipes;

    /**
     * @ORM\ManyToMany(targetEntity=Arbitre::class, inversedBy="r")
     */
    private $arbitres;

    /**
     * @ORM\ManyToMany(targetEntity=Ramasseur::class, mappedBy="rencontres")
     */
    private $ramasseurs;


    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $score = '';


    /**
     * @ORM\ManyToOne(targetEntity=Journee::class, inversedBy="rencontres")
     */
    private $journee;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_debut;

    /**
     * @ORM\ManyToOne(targetEntity=Court::class, inversedBy="rencontres")
     */
    private $court;


    public function __construct()
    {
        $this->equipes = new ArrayCollection();
        $this->arbitres = new ArrayCollection();
        $this->ramasseurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Equipe[]
     */
    public function getEquipes(): Collection
    {
        return $this->equipes;
    }

    public function addEquipe(Equipe $equipe): self
    {
        if (!$this->equipes->contains($equipe)) {
            $this->equipes[] = $equipe;
        }

        return $this;
    }

    public function removeEquipe(Equipe $equipe): self
    {
        $this->equipes->removeElement($equipe);

        return $this;
    }

    /**
     * @return Collection|Arbitre[]
     */
    public function getArbitres(): Collection
    {
        return $this->arbitres;
    }

    public function addArbitre(Arbitre $arbitre): self
    {
        if (!$this->arbitres->contains($arbitre)) {
            $this->arbitres[] = $arbitre;
        }

        return $this;
    }

    public function removeArbitre(Arbitre $arbitre): self
    {
        $this->arbitres->removeElement($arbitre);

        return $this;
    }

    /**
     * @return Collection|Ramasseur[]
     */
    public function getRamasseurs(): Collection
    {
        return $this->ramasseurs;
    }

    public function addRamasseur(Ramasseur $ramasseur): self
    {
        if (!$this->ramasseurs->contains($ramasseur)) {
            $this->ramasseurs[] = $ramasseur;
            $ramasseur->addRencontre($this);
        }

        return $this;
    }

    public function removeRamasseur(Ramasseur $ramasseur): self
    {
        if ($this->ramasseurs->removeElement($ramasseur)) {
            $ramasseur->removeRencontre($this);
        }

        return $this;
    }

    public function getScore(): ?string
    {
        return $this->score;
    }

    public function setScore(?string $score): self
    {
        $this->score = $score;

        return $this;
    }


    public function getJournee(): ?Journee
    {
        return $this->journee;
    }

    public function setJournee(?Journee $journee): self
    {
        $this->journee = $journee;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getCourt(): ?Court
    {
        return $this->court;
    }

    public function setCourt(?Court $court): self
    {
        $this->court = $court;

        return $this;
    }
}
