<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\LineRequestSuppliedRepository")
 */
class LineRequestSupplied
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
    private $quantity;

    /**
     * @ORM\Column(type="string")
     */
    private $remarque;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Article", inversedBy="lineRequestSupplieds", cascade={"persist","remove"})
     */
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\RequestSupplied", inversedBy="lineRequestSupplieds")
     * @ORM\JoinColumn(nullable=false)
     */
    private $requestSupplied;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getRemarque(): ?string
    {
        return $this->remarque;
    }

    public function setRemarque(string $remarque): self
    {
        $this->remarque = $remarque;

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

    public function getRequestSupplied(): ?RequestSupplied
    {
        return $this->requestSupplied;
    }

    public function setRequestSupplied(?RequestSupplied $requestSupplied): self
    {
        $this->requestSupplied = $requestSupplied;

        return $this;
    }
}
