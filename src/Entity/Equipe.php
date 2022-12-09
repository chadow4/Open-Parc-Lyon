<?php

namespace App\Entity;

use App\Repository\EquipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EquipeRepository::class)
 */
class Equipe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Rencontre::class, mappedBy="equipes")
     */
    private $rencontres;

    /**
     * @ORM\ManyToMany(targetEntity=Joueur::class, inversedBy="equipes")
     */
    private $joueurs;

    /**
     * @ORM\ManyToMany(targetEntity=Tournoi::class, mappedBy="equipes")
     */
    private $tournois;
    public function __construct()
    {
        $this->rencontres = new ArrayCollection();
        $this->joueurs = new ArrayCollection();
        $this->tournois = new ArrayCollection();
    }

    public function __toString()
    {
        $result = '';
        foreach ($this->joueurs as $joueur) {
            if(strlen($result) != 0) $result .= ' && ';
            $result .= $joueur->getNom();
        }
        return $this->id . ' - ' .$result;
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $rencontre->addEquipe($this);
        }

        return $this;
    }

    public function removeRencontre(Rencontre $rencontre): self
    {
        if ($this->rencontres->removeElement($rencontre)) {
            $rencontre->removeEquipe($this);
        }

        return $this;
    }

    /**
     * @return Collection|Joueur[]
     */
    public function getJoueurs(): Collection
    {
        return $this->joueurs;
    }

    public function addJoueur(Joueur $joueur): self
    {
        if (!$this->joueurs->contains($joueur)) {
            $this->joueurs[] = $joueur;
        }

        return $this;
    }

    public function removeJoueur(Joueur $joueur): self
    {
        $this->joueurs->removeElement($joueur);

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
            $tournoi->addEquipe($this);
        }

        return $this;
    }

    public function removeTournoi(Tournoi $tournoi): self
    {
        if ($this->tournois->removeElement($tournoi)) {
            $tournoi->removeEquipe($this);
        }

        return $this;
    }

}
