<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MenuRepository")
 * @UniqueEntity(fields={"day"}, message="لقد قمت بادخال المعطيات الخاصة بهذا اليوم")
 */
class Menu
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $day;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $breakfast;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lunch;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dinner;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(string $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getBreakfast(): ?string
    {
        return $this->breakfast;
    }

    public function setBreakfast(string $breakfast): self
    {
        $this->breakfast = $breakfast;

        return $this;
    }

    public function getLunch(): ?string
    {
        return $this->lunch;
    }

    public function setLunch(string $lunch): self
    {
        $this->lunch = $lunch;

        return $this;
    }

    public function getDinner(): ?string
    {
        return $this->dinner;
    }

    public function setDinner(string $dinner): self
    {
        $this->dinner = $dinner;

        return $this;
    }
    public function __toString()
    {
        return  $this->day;
        //. " " .$this->lunch." ".$this->dinner;

    }
}
