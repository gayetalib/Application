<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Entity\Departement;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ServiceRepository")
 * @UniqueEntity(
 *   fields="NomService",
 *   message="Ce service existe déjà. Veuillez entrer un autre"
 * )
 */
class Service
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
    private $NomService;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Departement", inversedBy="services")
     * @ORM\JoinColumn(nullable=true)
     */
    private $departements;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Consommation", mappedBy="services")
     */
    private $consommations;

    public function __toString()
    {
        return $this->NomService;
    }

    public function __construct()
    {
        $this->consommations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomService(): ?string
    {
        return $this->NomService;
    }

    public function setNomService(string $NomService): self
    {
        $this->NomService = $NomService;

        return $this;
    }

    public function getDepartements(): ?Departement
    {
        return $this->departements;
    }

    public function setDepartements(?Departement $departements): self
    {
        $this->departements = $departements;

        return $this;
    }

    /**
     * @return Collection|Consommation[]
     */
    public function getConsommations(): Collection
    {
        return $this->consommations;
    }

    public function addConsommation(Consommation $consommation): self
    {
        if (!$this->consommations->contains($consommation)) {
            $this->consommations[] = $consommation;
            $consommation->setServices($this);
        }

        return $this;
    }

    public function removeConsommation(Consommation $consommation): self
    {
        if ($this->consommations->contains($consommation)) {
            $this->consommations->removeElement($consommation);
            // set the owning side to null (unless already changed)
            if ($consommation->getServices() === $this) {
                $consommation->setServices(null);
            }
        }

        return $this;
    }
}
