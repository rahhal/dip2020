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
     * @ORM\Column(type="integer")
     */
    private $total_meals;

    /**
     * @ORM\Column(type="integer")
     */
    private $unit_cost;

    /**
     * @ORM\Column(type="text")
     */
    private $remarque;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Menu", inversedBy="journals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $menu;

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

    public function getTotalMeals(): ?int
    {
        return $this->total_meals;
    }

    public function setTotalMeals(int $total_meals): self
    {
        $this->total_meals = $total_meals;

        return $this;
    }


    public function getUnitCost(): ?int
    {
        return $this->unit_cost;
    }

    public function setUnitCost(int $unit_cost): self
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

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

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

}
