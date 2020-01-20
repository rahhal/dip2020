<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JournalRepository")
 */
class Journal
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
     * @ORM\Column(type="decimal", precision=15, scale=3)
     */
    private $unit_cost;

    /**
     * @ORM\Column(type="text")
     */
    private $remarque;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Exitt", inversedBy="journals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $exitt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\NbMeal", inversedBy="journals", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $nbMeal;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=3)
     */
    private $totalCosts;

    /**
     * @ORM\Column(type="integer")
     */
    private $totalMeals;



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



    public function getUnitCost(): ?string
    {
        return $this->unit_cost;
    }

    public function setUnitCost(string $unit_cost): self
    {
        $this->unit_cost = $unit_cost;

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

    public function getExitt(): ?Exitt
    {
        return $this->exitt;
    }

    public function setExitt(?Exitt $exitt): self
    {
        $this->exitt = $exitt;

        return $this;
    }

    public function getNbMeal(): ?NbMeal
    {
        return $this->nbMeal;
    }
    public function setNbMeal(?NbMeal $nbMeal): self
    {
        $this->nbMeal = $nbMeal;

        return $this;
    }

    public function getTotalCosts(): ?string
    {
        return $this->totalCosts;
    }

    public function setTotalCosts(string $totalCosts): self
    {
        $this->totalCosts = $totalCosts;

        return $this;
    }

    public function getTotalMeals(): ?int
    {
        return $this->totalMeals;
    }

    public function setTotalMeals(int $totalMeals): self
    {
        $this->totalMeals = $totalMeals;

        return $this;
    }

}
