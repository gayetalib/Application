<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DepartementRepository")
 * @UniqueEntity(
 *   fields="NomDepartement",
 *   message="Ce département existe déjà. Veuillez entrer un autre"
 * )
 */
class Departement
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
    public $NomDepartement;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Direction", inversedBy="departements")
     * @ORM\JoinColumn(nullable=true)
     */
    public $directions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Service", mappedBy="departements")
     */
    private $services;

    public function __toString()
    {
        return  $this->NomDepartement;
    }

    public function __construct()
    {
        $this->services = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomDepartement(): ?string
    {
        return $this->NomDepartement;
    }

    public function setNomDepartement(string $NomDepartement): self
    {
        $this->NomDepartement = $NomDepartement;

        return $this;
    }

    public function getDirections(): ?Direction
    {
        return $this->directions;
    }

    public function setDirections(?Direction $directions): self
    {
        $this->directions = $directions;

        return $this;
    }

    /**
     * @return Collection|Service[]
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Service $service): self
    {
        if (!$this->services->contains($service)) {
            $this->services[] = $service;
            $service->setDepartements($this);
        }

        return $this;
    }

    public function removeService(Service $service): self
    {
        if ($this->services->contains($service)) {
            $this->services->removeElement($service);
            // set the owning side to null (unless already changed)
            if ($service->getDepartements() === $this) {
                $service->setDepartements(null);
            }
        }

        return $this;
    }
}
