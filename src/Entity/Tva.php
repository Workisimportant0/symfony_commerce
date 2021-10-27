<?php

namespace App\Entity;

use App\Repository\TvaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TvaRepository::class)
 */
class Tva
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $tauxReduit;

    /**
     * @ORM\Column(type="float")
     */
    private $tauxIntermediaire;

    /**
     * @ORM\OneToMany(targetEntity=Produit::class, mappedBy="tva")
     */
    private $produits;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTauxReduit(): ?float
    {
        return $this->tauxReduit;
    }

    public function setTauxReduit(float $tauxReduit): self
    {
        $this->tauxReduit = $tauxReduit;

        return $this;
    }

    public function getTauxIntermediaire(): ?float
    {
        return $this->tauxIntermediaire;
    }

    public function setTauxIntermediaire(float $tauxIntermediaire): self
    {
        $this->tauxIntermediaire = $tauxIntermediaire;

        return $this;
    }

    /**
     * @return Collection|Produit[]
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
            $produit->setTva($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getTva() === $this) {
                $produit->setTva(null);
            }
        }

        return $this;
    }
}
