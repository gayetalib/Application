<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FournisseurRepository")
 * @UniqueEntity(
 *   fields="NomFournisseur",
 *   message="Ce fournisseur est déjà entré !"
 * )
 */
class Fournisseur
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
    private $NomFournisseur;

    /**
     *  @Assert\GreaterThan(
     *  value=0,
     *  message="Cette valeur doit etre positive"
     * )
     * @ORM\Column(type="integer")
     */
    private $numeroFournisseur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $AdresseFournisseur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $MailFournisseur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $BoitePostale;

    /**
     * @ORM\Column(type="integer")
     */
    private $Fax;

    // /**
    //  * @ORM\Column(type="integer")
    //  */
    // private $etats;

    // /**
    //  * @ORM\Column(type="string")
    //  */
    // private $situations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Approvisionnement", mappedBy="fournisseurs")
     */
    private $approvisionnements;

    public function __toString()
    {
        return $this->NomFournisseur;
    }

    public function __construct()
    {
        $this->approvisionnements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomFournisseur(): ?string
    {
        return $this->NomFournisseur;
    }

    public function setNomFournisseur(string $NomFournisseur): self
    {
        $this->NomFournisseur = $NomFournisseur;

        return $this;
    }

    public function getNumeroFournisseur(): ?int
    {
        return $this->numeroFournisseur;
    }

    public function setNumeroFournisseur(int $numeroFournisseur): self
    {
        $this->numeroFournisseur = $numeroFournisseur;

        return $this;
    }

    public function getAdresseFournisseur(): ?string
    {
        return $this->AdresseFournisseur;
    }

    public function setAdresseFournisseur(string $AdresseFournisseur): self
    {
        $this->AdresseFournisseur = $AdresseFournisseur;

        return $this;
    }

    public function getMailFournisseur(): ?string
    {
        return $this->MailFournisseur;
    }

    public function setMailFournisseur(string $MailFournisseur): self
    {
        $this->MailFournisseur = $MailFournisseur;

        return $this;
    }

    public function getBoitePostale(): ?string
    {
        return $this->BoitePostale;
    }

    public function setBoitePostale(string $BoitePostale): self
    {
        $this->BoitePostale = $BoitePostale;

        return $this;
    }

    public function getFax(): ?int
    {
        return $this->Fax;
    }

    public function setFax(int $Fax): self
    {
        $this->Fax = $Fax;

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
            $approvisionnement->setFournisseurs($this);
        }

        return $this;
    }

    public function removeApprovisionnement(Approvisionnement $approvisionnement): self
    {
        if ($this->approvisionnements->contains($approvisionnement)) {
            $this->approvisionnements->removeElement($approvisionnement);
            // set the owning side to null (unless already changed)
            if ($approvisionnement->getFournisseurs() === $this) {
                $approvisionnement->setFournisseurs(null);
            }
        }

        return $this;
    }
}
