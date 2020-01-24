<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    private $qty_inv;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Article", inversedBy="lineInventories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Inventory", inversedBy="lineInventories",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $inventory;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\LineStock", inversedBy="lineInventories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $lineStock;


    public function getId(): ?int
    {
        return $this->id;
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

    public function getLineStock(): ?LineStock
    {
        return $this->lineStock;
    }

    public function setLineStock(?LineStock $lineStock): self
    {
        $this->lineStock = $lineStock;

        return $this;
    }


}
