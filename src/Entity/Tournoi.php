<?php

namespace App\Entity;

use App\Repository\TournoiRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TournoiRepository::class)
 */
class Tournoi
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
    private $type;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_debut;

    /**
     * @ORM\ManyToMany(targetEntity=Arbitre::class, inversedBy="tournois")
     */
    private $arbitres;

    /**
     * @ORM\OneToMany(targetEntity=Rencontre::class, mappedBy="tournoi")
     */
    private $rencontres;

    /**
     * @ORM\OneToMany(targetEntity=Journee::class, mappedBy="tournoi")
     */
    private $journees;

    /**
     * @ORM\ManyToMany(targetEntity=Ramasseur::class, inversedBy="tournois")
     */
    private $ramasseurs;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nombre_tour;

    /**
     * @ORM\ManyToMany(targetEntity=Equipe::class, inversedBy="tournois")
     */
    private $equipes;

    public function __construct()
    {
        $this->arbitres = new ArrayCollection();
        $this->rencontres = new ArrayCollection();
        $this->journees = new ArrayCollection();
        $this->ramasseurs = new ArrayCollection();
        $this->equipes = new ArrayCollection();
    }

    public function __toString()
    {
        return 'Tournoi '.$this->type. ' - '. $this->date_debut->format('m-Y');
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

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
            $rencontre->setTournoi($this);
        }

        return $this;
    }

    public function removeRencontre(Rencontre $rencontre): self
    {
        if ($this->rencontres->removeElement($rencontre)) {
            // set the owning side to null (unless already changed)
            if ($rencontre->getTournoi() === $this) {
                $rencontre->setTournoi(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Journee[]
     */
    public function getJournees(): Collection
    {
        return $this->journees;
    }

    public function addJournee(Journee $journee): self
    {
        if (!$this->journees->contains($journee)) {
            $this->journees[] = $journee;
            $journee->setTournoi($this);
        }

        return $this;
    }

    public function removeJournee(Journee $journee): self
    {
        if ($this->journees->removeElement($journee)) {
            // set the owning side to null (unless already changed)
            if ($journee->getTournoi() === $this) {
                $journee->setTournoi(null);
            }
        }

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
        }

        return $this;
    }

    public function removeRamasseur(Ramasseur $ramasseur): self
    {
        $this->ramasseurs->removeElement($ramasseur);

        return $this;
    }

    public function getNombreTour(): ?int
    {
        return $this->nombre_tour;
    }

    public function setNombreTour(int $nombre_tour): self
    {
        $this->nombre_tour = $nombre_tour;

        return $this;
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
}
