<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RequestSuppliedRepository")
 */
class RequestSupplied
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tranche;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Supplier", inversedBy="requestSupplieds")
     * @ORM\JoinColumn(nullable=false)
     */
    private $supplier;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LineRequestSupplied", mappedBy="requestSupplied", cascade={"persist"}, orphanRemoval=true)
     */
    private $lineRequestSupplieds;

    public function __construct()
    {
        $this->lineRequestSupplieds = new ArrayCollection();
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
     * @return Collection|LineRequestSupplied[]
     */
    public function getLineRequestSupplieds(): Collection
    {
        return $this->lineRequestSupplieds;
    }

    public function addLineRequestSupplied(LineRequestSupplied $lineRequestSupplied): self
    {
        if (!$this->lineRequestSupplieds->contains($lineRequestSupplied)) {
            $this->lineRequestSupplieds[] = $lineRequestSupplied;
            $lineRequestSupplied->setRequestSupplied($this);
        }

        return $this;
    }

    public function removeLineRequestSupplied(LineRequestSupplied $lineRequestSupplied): self
    {
        if ($this->lineRequestSupplieds->contains($lineRequestSupplied)) {
            $this->lineRequestSupplieds->removeElement($lineRequestSupplied);
            // set the owning side to null (unless already changed)
            if ($lineRequestSupplied->getRequestSupplied() === $this) {
                $lineRequestSupplied->setRequestSupplied(null);
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
