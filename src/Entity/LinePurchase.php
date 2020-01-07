<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LinePurchaseRepository")
 */
class LinePurchase
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Article", inversedBy="linePurchases" , cascade={"persist","remove"})
     */
    private $article;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity_delivred;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=3)
     */
    private $unit_price;

    /**
     * @ORM\Column(type="integer", length=10)
     */
    private $tax;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Purchase", inversedBy="linePurchases")
     * @ORM\JoinColumn(nullable=false)
     */
    private $purchase;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantity_required;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $technical_confirmity;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LineStock", mappedBy="line_purchase")
     */
    private $lineStocks;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $remarque;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=3)
     */
    private $total_price;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $production;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $validation;


    public function __construct()
    {
        $this->lineStocks = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getQuantityDelivred(): ?int
    {
        return $this->quantity_delivred;
    }

    public function setQuantityDelivred(int $quantity_delivred): self
    {
        $this->quantity_delivred = $quantity_delivred;

        return $this;
    }

    public function getUnitPrice(): ?string
    {
        return $this->unit_price;
    }

    public function setUnitPrice(string $unit_price): self
    {
        $this->unit_price = $unit_price;

        return $this;
    }

    public function getTax(): ?int
    {
        return $this->tax;
    }

    public function setTax(int $tax): self
    {
        $this->tax = $tax;

        return $this;
    }

    public function getPurchase(): ?Purchase
    {
        return $this->purchase;
    }

    public function setPurchase(?Purchase $purchase): self
    {
        $this->purchase = $purchase;

        return $this;
    }

    /*public function __toString()
    {
      return $this-> valid;   // TODO: Implement __toString() method.
    }*/
    public function getQuantityRequired(): ?int
    {
        return $this->quantity_required;
    }

    public function setQuantityRequired(int $quantity_required): self
    {
        $this->quantity_required = $quantity_required;

        return $this;
    }

    public function getTechnicalConfirmity(): ?bool
    {
        return $this->technical_confirmity;
    }

    public function setTechnicalConfirmity(bool $technical_confirmity): self
    {
        $this->technical_confirmity = $technical_confirmity;

        return $this;
    }

    /**
     * @return Collection|lineStock[]
     */
    public function getLineStocks(): Collection
    {
        return $this->lineStocks;
    }

    public function addLineStock(lineStock $lineStock): self
    {
        if (!$this->lineStocks->contains($lineStock)) {
            $this->lineStocks[] = $lineStock;
            $lineStock->setLinePurchase($this);
        }

        return $this;
    }

    public function removeLineStock(lineStock $lineStock): self
    {
        if ($this->lineStocks->contains($lineStock)) {
            $this->lineStocks->removeElement($lineStock);
            // set the owning side to null (unless already changed)
            if ($lineStock->getLinePurchase() === $this) {
                $lineStock->setLinePurchase(null);
            }
        }

        return $this;
    }

    public function getRemarque(): ?string
    {
        return $this->remarque;
    }

    public function setRemarque(string $remarque): self
    {
        $this->remarque = $remarque;

        return $this;
    }

    public function getTotalPrice(): ?string
    {
        return $this->total_price;
    }

    public function setTotalPrice(string $total_price): self
    {
        $this->total_price = $total_price;

        return $this;
    }

    public function getProduction(): ?string
    {
        return $this->production;
    }

    public function setProduction(string $production): self
    {
        $this->production = $production;

        return $this;
    }

    public function getValidation(): ?string
    {
        return $this->validation;
    }

    public function setValidation(string $validation): self
    {
        $this->validation = $validation;

        return $this;
    }

}