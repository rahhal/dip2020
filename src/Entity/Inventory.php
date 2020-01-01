<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InventoryRepository")
 */
class Inventory
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
     * @ORM\OneToMany(targetEntity="App\Entity\LineInventory", mappedBy="inventory")
     */
    private $lineInventories;

    public function __construct()
    {
        $this->lineInventories = new ArrayCollection();
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
            $lineInventory->setInventory($this);
        }

        return $this;
    }

    public function removeLineInventory(LineInventory $lineInventory): self
    {
        if ($this->lineInventories->contains($lineInventory)) {
            $this->lineInventories->removeElement($lineInventory);
            // set the owning side to null (unless already changed)
            if ($lineInventory->getInventory() === $this) {
                $lineInventory->setInventory(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return "";
    }
}
