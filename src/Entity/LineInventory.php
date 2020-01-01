<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LineInventoryRepository")
 */
class LineInventory
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
    private $qty_th;

    /**
     * @ORM\Column(type="integer")
     */
    private $qty_inv;

    /**
     * @ORM\Column(type="float")
     */
    private $difference;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Article", inversedBy="lineInventories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Inventory", inversedBy="lineInventories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $inventory;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQtyTh(): ?int
    {
        return $this->qty_th;
    }

    public function setQtyTh(int $qty_th): self
    {
        $this->qty_th = $qty_th;

        return $this;
    }

    public function getQtyInv(): ?int
    {
        return $this->qty_inv;
    }

    public function setQtyInv(int $qty_inv): self
    {
        $this->qty_inv = $qty_inv;

        return $this;
    }

    public function getDifference(): ?float
    {
        return $this->difference;
    }

    public function setDifference(float $difference): self
    {
        $this->difference = $difference;

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

    public function getInventory(): ?Inventory
    {
        return $this->inventory;
    }

    public function setInventory(?Inventory $inventory): self
    {
        $this->inventory = $inventory;

        return $this;
    }
}
