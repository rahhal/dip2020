<?php

namespace App\Entity;

use App\Entity\LineStock;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LineExittRepository")
 */
class LineExitt
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
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Exitt", inversedBy="lineExitts",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $exitt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Article", inversedBy="lineExitts")
     */
    private $article;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\LineStock", inversedBy="lineExitts")
     */
    private $lineStocks;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=3)
     */
    private $unitPrice;


    public function __construct()
    {
        $this->lineStocks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }


    public function getExitt(): ?Exitt
    {
        return $this->exitt;
    }

    public function setExitt(?Exitt $exitt): self
    {
        $this->exitt = $exitt;

        return $this;
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
        }

        return $this;
    }

    public function removeLineStock(lineStock $lineStock): self
    {
        if ($this->lineStocks->contains($lineStock)) {
            $this->lineStocks->removeElement($lineStock);
        }

        return $this;
    }

    public function __toString()
    {
        return " ";
            //. " " .$this->exitt. " " .$this->quantity. " " .$this->unit_price. " " .$this->tax. " " .$this->total_price;
    }

    public function getUnitPrice(): ?string
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(string $unitPrice): self
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }
}
