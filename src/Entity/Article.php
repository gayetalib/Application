<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 * @UniqueEntity(
 *   fields="NomArticle",
 *   message="Cet article existe déjà. Veuillez entrer un autre"
 * )
 */
class Article
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
    private $NomArticle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Designation;

    /**
     *  @Assert\GreaterThan(
     *  value=0,
     *  message="Cette valeur doit etre positive"
     * )
     * @ORM\Column(type="integer")
     */
    private $AlerteStock;

    /**
     * @ORM\Column(type="integer")
     */
    private $etat;

    /**
     * @ORM\Column(type="string")
     */
    private $situation;

    /**
     * @Assert\GreaterThan(
     *  value=0,
     *  message="Cette valeur doit etre positive"
     * )
     * @ORM\Column(type="integer")
     */
    public $QuantiteStock;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeArticle", inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $types;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UniteArticle", inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $unites;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Consommation", mappedBy="articles")
     */
    private $consommations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Approvisionnement", mappedBy="articles")
     */
    private $approvisionnements;

    public function __toString()
    {
        return $this->NomArticle;
    }

    public function __construct()
    {
        $this->consommations = new ArrayCollection();
        $this->approvisionnements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomArticle(): ?string
    {
        return $this->NomArticle;
    }

    public function setNomArticle(string $NomArticle): self
    {
        $this->NomArticle = $NomArticle;

        return $this;
    }

    public function getDesignation(): ?string
    {
        return $this->Designation;
    }

    public function setDesignation(string $Designation): self
    {
        $this->Designation = $Designation;

        return $this;
    }

    public function getTypes(): ?TypeArticle
    {
        return $this->types;
    }

    public function setTypes(?TypeArticle $types): self
    {
        $this->types = $types;

        return $this;
    }

    public function getUnites(): ?UniteArticle
    {
        return $this->unites;
    }

    public function setUnites(?UniteArticle $unites): self
    {
        $this->unites = $unites;

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
            $consommation->setArticles($this);
        }

        return $this;
    }

    public function removeConsommation(Consommation $consommation): self
    {
        if ($this->consommations->contains($consommation)) {
            $this->consommations->removeElement($consommation);
            // set the owning side to null (unless already changed)
            if ($consommation->getArticles() === $this) {
                $consommation->setArticles(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Approvisionnement[]
     */
    public function getApprovisionnements(): Collection
    {
        return $this->approvisionnements;
    }

    public function addApprovisionnement(Approvisionnement $approvisionnement): self
    {
        if (!$this->approvisionnements->contains($approvisionnement)) {
            $this->approvisionnements[] = $approvisionnement;
            $approvisionnement->setArticles($this);
        }

        return $this;
    }

    public function removeApprovisionnement(Approvisionnement $approvisionnement): self
    {
        if ($this->approvisionnements->contains($approvisionnement)) {
            $this->approvisionnements->removeElement($approvisionnement);
            // set the owning side to null (unless already changed)
            if ($approvisionnement->getArticles() === $this) {
                $approvisionnement->setArticles(null);
            }
        }

        return $this;
    }

    public function getServices(): ?Service
    {
        return $this->services;
    }

    public function setServices(?Service $services): self
    {
        $this->services = $services;

        return $this;
    }

    public function getQuantiteStock(): ?int
    {
        return $this->QuantiteStock;
    }

    public function setQuantiteStock(int $QuantiteStock): self
    {
        $this->QuantiteStock = $QuantiteStock;

        return $this;
    }

    public function getEtat(): ?int
    {
        return $this->etat;
    }

    public function setEtat(int $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getAlerteStock(): ?int
    {
        return $this->AlerteStock;
    }

    public function setAlerteStock(int $AlerteStock): self
    {
        $this->AlerteStock = $AlerteStock;

        return $this;
    }

    public function getSituation(): ?string
    {
        return $this->situation;
    }

    public function setSituation(string $situation): self
    {
        $this->situation = $situation;
        return $this;
    }

   
}
