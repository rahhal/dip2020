<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DemandRepository")
 */
class Demand
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
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tranche;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Supplier", inversedBy="demands")
     * @ORM\JoinColumn(nullable=false)
     */
    private $supplier;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LineDemand", mappedBy="demand",cascade={"persist"}, orphanRemoval=true)
     */
    private $lineDemands;

    public function __construct()
    {
        $this->lineDemands = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
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

    public function getTranche(): ?string
    {
        return $this->tranche;
    }

    public function setTranche(string $tranche): self
    {
        $this->tranche = $tranche;

        return $this;
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

    /**
     * @return Collection|LineDemand[]
     */
    public function getLineDemands(): Collection
    {
        return $this->lineDemands;
    }

    public function addLineDemand(LineDemand $lineDemand): self
    {
        if (!$this->lineDemands->contains($lineDemand)) {
            $this->lineDemands[] = $lineDemand;
            $lineDemand->setDemand($this);
        }

        return $this;
    }

    public function removeLineDemand(LineDemand $lineDemand): self
    {
        if ($this->lineDemands->contains($lineDemand)) {
            $this->lineDemands->removeElement($lineDemand);
            // set the owning side to null (unless already changed)
            if ($lineDemand->getDemand() === $this) {
                $lineDemand->setDemand(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this-> tranche;
    }
}
