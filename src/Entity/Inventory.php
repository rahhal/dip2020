<?php

namespace App\Entity;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Article")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article;

    /**
     * @ORM\Column(type="float")
     */
    private $state;

    /**
     * @ORM\Column(type="integer")
     */
    private $qty_inv;

    /**
     * @ORM\Column(type="integer")
     */
    private $qty_stk;

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

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getState(): ?float
    {
        return $this->state;
    }

    public function setState(float $state): self
    {
        $this->state = $state;

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

    public function getQtyStk(): ?int
    {
        return $this->qty_stk;
    }

    public function setQtyStk(int $qty_stk): self
    {
        $this->qty_stk = $qty_stk;

        return $this;
    }
}
