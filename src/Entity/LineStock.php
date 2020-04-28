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
     * @ORM\Column(type="date", nullable=true)
     */
    private $valid_date;

    /**
     * @ORM\Column(type="date", nullable=true)
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


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LineInventory", mappedBy="lineStock",cascade={"persist","remove"})
     */
    private $lineInventories;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=3)
     */
    private $unitPrice;
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\LineExitt", mappedBy="lineStocks")
     */
    private $lineExitts;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="lineStocks")
     */
    private $user;

    public function __construct()
    {
       $this->lineExitts = new ArrayCollection();
        $this->lineInventories = new ArrayCollection();
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

public function getDate(): ?\DateTimeInterface
{
    return $this->date;
}

public function setDate(\DateTimeInterface $date): self
{
    $this->date = $date;

    return $this;
}

/**
 * @return Collection|LineInventory[]
 */
public function getLineInventories(): Collection
{
    return $this->lineInventories;
}

public function addLineInventory(LineInventory $lineInventory): self
{
    if (!$this->lineInventories->contains($lineInventory)) {
        $this->lineInventories[] = $lineInventory;
        $lineInventory->setLineStock($this);
    }

    return $this;
}

public function removeLineInventory(LineInventory $lineInventory): self
{
    if ($this->lineInventories->contains($lineInventory)) {
        $this->lineInventories->removeElement($lineInventory);
        // set the owning side to null (unless already changed)
        if ($lineInventory->getLineStock() === $this) {
            $lineInventory->setLineStock(null);
        }
    }

    return $this;
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
    /**
     * @return Collection|lineExitt[]
     */
    public function getLineExitts(): Collection
    {
        return $this->lineExitts;
    }

    public function addLineExitt(lineExitt $lineExitt): self
    {
        if (!$this->lineExitts->contains($lineExitt)) {
            $this->lineExitts[] = $lineExitt;
        }

        return $this;
    }

    public function removeLineExitt(lineExitt $lineExitt): self
    {
        if ($this->lineExitts->contains($lineExitt)) {
            $this->lineExitts->removeElement($lineExitt);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->reference;// TODO: Implement __toString() method.
}

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
