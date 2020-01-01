<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LineStockRepository")
 */
class LineStock
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
    private $qty_update;

    /**
     * @ORM\Column(type="integer")
     */
    private $old_qty;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity_alerte;

    /**
     * @ORM\Column(type="date")
     */
    private $valid_date;

    /**
     * @ORM\Column(type="date")
     */
    private $prod_date;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\LinePurchase", inversedBy="lineStocks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $line_purchase;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Stock", inversedBy="lineStocks",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $stock;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reference;

    /**
     * @ORM\Column(type="date")
     */
    private $date;


    public function __construct()
    {

        $this->lineExit = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQtyUpdate(): ?int
    {
        return $this->qty_update;
    }

    public function setQtyUpdate(int $qty_update): self
    {
        $this-> qty_update = $qty_update;

        return $this;
    }

    public function getOldQty(): ?int
    {
        return $this->old_qty;
    }

    public function setOldQty(int $old_qty): self
    {
        $this->old_qty = $old_qty;

        return $this;
    }

    public function getQuantityAlerte(): ?int
    {
        return $this->quantity_alerte;
    }

    public function setQuantityAlerte(int $quantity_alerte): self
    {
        $this->quantity_alerte = $quantity_alerte;

        return $this;
    }

    public function getValidDate(): ?\DateTimeInterface
    {
        return $this->valid_date;
    }

    public function setValidDate(\DateTimeInterface $valid_date): self
    {
        $this->valid_date = $valid_date;

        return $this;
    }

    public function getProdDate(): ?\DateTimeInterface
    {
        return $this->prod_date;
    }

    public function setProdDate(\DateTimeInterface $prod_date): self
    {
        $this->prod_date = $prod_date;

        return $this;
    }
    public function getLinePurchase(): ?LinePurchase
    {
        return $this->line_purchase;
    }

    public function setLinePurchase(?LinePurchase $line_purchase): self
    {
        $this->line_purchase = $line_purchase;

        return $this;
    }

    public function getStock(): ?Stock
    {
        return $this->stock;
    }

    public function setStock(?Stock $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }
public function __toString()
{
    return $this-> reference;// TODO: Implement __toString() method.
}

public function getDate(): ?\DateTimeInterface
{
    return $this->date;
}

public function setDate(\DateTimeInterface $date): self
{
    $this->date = $date;

    return $this;
}

}
