<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UniteArticleRepository")
 * @UniqueEntity(
 *   fields="NomUnite",
 *   message="Cet unité d'article existe déjà. Veuillez entrer une autre"
 * )
 */
class UniteArticle
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
    private $NomUnite;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="unites")
     */
    private $articles;

    public function __toString()
    {
        return $this->NomUnite;
    }

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomUnite(): ?string
    {
        return $this->NomUnite;
    }

    public function setNomUnite(string $NomUnite): self
    {
        $this->NomUnite = $NomUnite;

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setUnites($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
            // set the owning side to null (unless already changed)
            if ($article->getUnites() === $this) {
                $article->setUnites(null);
            }
        }

        return $this;
    }
}
