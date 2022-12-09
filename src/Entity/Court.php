<?php

namespace App\Entity;

use App\Repository\CourtRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CourtRepository::class)
 */
class Court
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
    private $numero;

    /**
     * @ORM\OneToMany(targetEntity=Journee::class, mappedBy="court")
     */
    private $journees;

    /**
     * @ORM\OneToMany(targetEntity=Rencontre::class, mappedBy="court")
     */
    private $rencontres;

    public function __construct()
    {
        $this->rencontres = new ArrayCollection();
        $this->journees = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->numero;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

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
            $journee->setCourt($this);
        }

        return $this;
    }

    public function removeJournee(Journee $journee): self
    {
        if ($this->journees->removeElement($journee)) {
            // set the owning side to null (unless already changed)
            if ($journee->getCourt() === $this) {
                $journee->setCourt(null);
            }
        }

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
            $rencontre->setCourt($this);
        }

        return $this;
    }

    public function removeRencontre(Rencontre $rencontre): self
    {
        if ($this->rencontres->removeElement($rencontre)) {
            // set the owning side to null (unless already changed)
            if ($rencontre->getCourt() === $this) {
                $rencontre->setCourt(null);
            }
        }

        return $this;
    }
}
