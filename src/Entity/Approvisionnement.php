<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ApprovisionnementRepository")
 * @UniqueEntity(
 *   fields="NumeroCommande",
 *   message="Ce numero de Commande est déjà entré"
 * )
 */
class Approvisionnement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $NumeroCommande;

    /**
     * @ORM\Column(type="date")
     */
    private $DateEntree;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Fournisseur", inversedBy="approvisionnements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fournisseurs;

    /**
     *  @Assert\GreaterThan(
     *  value=0,
     *  message="Cette valeur doit etre positive"
     * )
     * @ORM\Column(type="integer")
     */
    public $QuantiteApprov; 

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Article", inversedBy="approvisionnements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $articles;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroCommande(): ?int
    {
        return $this->NumeroCommande;
    }

    public function setNumeroCommande(int $NumeroCommande): self
    {
        $this->NumeroCommande = $NumeroCommande;

        return $this;
    }

    public function getDateEntree(): ?\DateTimeInterface
    {
        return $this->DateEntree;
    }

    public function setDateEntree(\DateTimeInterface $DateEntree): self
    {
        $this->DateEntree = $DateEntree;

        return $this;
    }

    public function getFournisseurs(): ?Fournisseur
    {
        return $this->fournisseurs;
    }

    public function setFournisseurs(?Fournisseur $fournisseurs): self
    {
        $this->fournisseurs = $fournisseurs;

        return $this;
    }

    public function getArticles(): ?Article
    {
        return $this->articles;
    }

    public function setArticles(?Article $articles): self
    {
        $this->articles = $articles;

        return $this;
    }

    public function getQuantiteApprov(): ?int
    {
        return $this->QuantiteApprov;
    }

    public function setQuantiteApprov(int $QuantiteApprov): self
    {
        $this->QuantiteApprov = $QuantiteApprov;

        return $this;
    }
}
