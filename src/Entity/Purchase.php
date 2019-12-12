<?php

namespace App\Entity;
use App\Entity\LinePurchase;
use App\Entity\Supplier;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PurchaseRepository")
 */
class Purchase
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
    private $number;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Employee")
     * @ORM\JoinColumn(nullable=false)
     */
    private $employee;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LinePurchase", mappedBy="purchase",cascade={"persist"}, orphanRemoval=true)
     */
    private $linePurchases;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Supplier", inversedBy="purchases")
     * @ORM\JoinColumn(nullable=false)
     */
    private $supplier;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=3)
     */
    private $total_price;


    public function __construct()
    {
        $this->linePurchases = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

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

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): self
    {
        $this->employee = $employee;

        return $this;
    }

    /**
     * @return Collection|LinePurchase[]
     */
    public function getLinePurchases(): Collection
    {
        return $this->linePurchases;
    }

    public function addLinePurchase(LinePurchase $linePurchase): self
    {
        if (!$this->linePurchases->contains($linePurchase)) {
            $this->linePurchases[] = $linePurchase;
            $linePurchase->setPurchase($this);
        }

        return $this;
    }

    public function removeLinePurchase(LinePurchase $linePurchase): self
    {
        if ($this->linePurchases->contains($linePurchase)) {
            $this->linePurchases->removeElement($linePurchase);
            // set the owning side to null (unless already changed)
            if ($linePurchase->getPurchase() === $this) {
                $linePurchase->setPurchase(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        // TODO: Implement __toString() method.
        return  $this-> number;
    }

    public function getSupplier(): ?Supplier
    {
        return $this->supplier;
    }

    public function setSupplier(?Supplier $supplier): self
    {
        $this->supplier = $supplier;

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
}
