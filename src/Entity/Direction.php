<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DirectionRepository")
 * @UniqueEntity(
 *   fields="NomDirection",
 *   message="Cette direction existe déjà. Veuillez entrer une autre"
 * )
 */
class Direction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $NomDirection;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Departement", mappedBy="directions")
     */
    private $departements;

    public function __toString()
    {
        return $this->NomDirection;
    }

    public function __construct()
    {
        $this->departements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomDirection(): ?string
    {
        return $this->NomDirection;
    }

    public function setNomDirection(string $NomDirection): self
    {
        $this->NomDirection = $NomDirection;

        return $this;
    }

    /**
     * @return Collection|Departement[]
     */
    public function getDepartements(): Collection
    {
        return $this->departements;
    }

    public function addDepartement(Departement $departement): self
    {
        if (!$this->departements->contains($departement)) {
            $this->departements[] = $departement;
            $departement->setDirections($this);
        }

        return $this;
    }

    public function removeDepartement(Departement $departement): self
    {
        if ($this->departements->contains($departement)) {
            $this->departements->removeElement($departement);
            // set the owning side to null (unless already changed)
            if ($departement->getDirections() === $this) {
                $departement->setDirections(null);
            }
        }

        return $this;
    }
}
