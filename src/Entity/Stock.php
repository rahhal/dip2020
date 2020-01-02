<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StockRepository")
 */
class Stock
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LineStock", mappedBy="stock")
     */
    private $lineStocks;


    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->lineStocks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
            $lineStock->setStock($this);
        }

        return $this;
    }

    public function removeLineStock(lineStock $lineStock): self
    {
        if ($this->lineStocks->contains($lineStock)) {
            $this->lineStocks->removeElement($lineStock);
            // set the owning side to null (unless already changed)
            if ($lineStock->getStock() === $this) {
                $lineStock->setStock(null);
            }
        }

        return $this;
    }
    /*public function __toString()
    {
       return $this-> name;// TODO: Implement __toString() method.
    }*/
}
