<?php

namespace App\Entity;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\AbstractType;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ConsommationRepository")
 */
class Consommation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $DateConsommation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Service", inversedBy="consommations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $services;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Article", inversedBy="consommations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $articles;

    /**
     *  @Assert\GreaterThan(
     *  value=0,
     *  message="Cette valeur doit etre positive"
     * )
     * @ORM\Column(type="integer")
     */
    public $QuantiteCons;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateConsommation(): ?\DateTimeInterface
    {
        return $this->DateConsommation;
    }

    public function setDateConsommation(\DateTimeInterface $DateConsommation): self
    {
        //  $this->dateCreated = new \DateTime();
        $this->DateConsommation = $DateConsommation;

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

    public function getArticles(): ?Article
    {
        return $this->articles;
    }

    public function setArticles(?Article $articles): self
    {
        $this->articles = $articles;

        return $this;
    }

    public function getQuantiteCons(): ?int
    {
        return $this->QuantiteCons;
    }

    public function setQuantiteCons(int $QuantiteCons): self
    {
        $this->QuantiteCons = $QuantiteCons;

        return $this;
    }
}
