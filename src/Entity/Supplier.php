<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SupplierRepository")
 */
class Supplier
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
    private $company;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $activity;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tax_number;

    /**
     * @Assert\Regex("/^[0-9]{8}/")
     * @ORM\Column(type="integer")
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     * * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Purchase", mappedBy="supplier", orphanRemoval=true)
     */
    private $purchases;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RequestSupplied", mappedBy="supplier", orphanRemoval=true)
     */
    private $requestSupplieds;

    public function __construct()
    {
        $this->purchases = new ArrayCollection();
        $this->requestSupplieds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(string $company): self
    {
        $this->company = $company;

        return $this;
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

    public function getActivity(): ?string
    {
        return $this->activity;
    }

    public function setActivity(string $activity): self
    {
        $this->activity = $activity;

        return $this;
    }

    public function getTaxNumber(): ?string
    {
        return $this->tax_number;
    }

    public function setTaxNumber(string $tax_number): self
    {
        $this->tax_number = $tax_number;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|Purchase[]
     */
    public function getPurchases(): Collection
    {
        return $this->purchases;
    }

    public function addPurchase(Purchase $purchase): self
    {
        if (!$this->purchases->contains($purchase)) {
            $this->purchases[] = $purchase;
            $purchase->setSupplier($this);
        }

        return $this;
    }

    public function removePurchase(Purchase $purchase): self
    {
        if ($this->purchases->contains($purchase)) {
            $this->purchases->removeElement($purchase);
            // set the owning side to null (unless already changed)
            if ($purchase->getSupplier() === $this) {
                $purchase->setSupplier(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->company;   // TODO: Implement __toString() method.
    }

    /**
     * @return Collection|RequestSupplied[]
     */
    public function getRequestSupplieds(): Collection
    {
        return $this->requestSupplieds;
    }

    public function addRequestSupplied(RequestSupplied $requestSupplied): self
    {
        if (!$this->requestSupplieds->contains($requestSupplied)) {
            $this->requestSupplieds[] = $requestSupplied;
            $requestSupplied->setSupplier($this);
        }

        return $this;
    }

    public function removeRequestSupplied(RequestSupplied $requestSupplied): self
    {
        if ($this->requestSupplieds->contains($requestSupplied)) {
            $this->requestSupplieds->removeElement($requestSupplied);
            // set the owning side to null (unless already changed)
            if ($requestSupplied->getSupplier() === $this) {
                $requestSupplied->setSupplier(null);
            }
        }

        return $this;
    }
}
