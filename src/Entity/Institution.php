<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InstitutionRepository")
 */
class Institution
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
    private $ministry;

    /**
     * @ORM\Column(type="string", length=255)
     *  * @Assert\NotBlank(message="Get creative and think of a title!")
     */
    private $office;

    /**
     * @ORM\Column(type="string", length=255)
     *  * @Assert\NotBlank(message="Get creative and think of a title!")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     *  * @Assert\NotBlank(message="Get creative and think of a title!")
     */
    private $director;

    /**
     * @ORM\Column(type="string", length=255)
     *  * @Assert\NotBlank(message="Get creative and think of a title!")
     */
    private $economist;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $administrator;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="integer")
     */
    private $phone;

    /**
     * @ORM\Column(type="integer")
     */
    private $fax;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $year;


     /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="institutions")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMinistry(): ?string
    {
        return $this->ministry;
    }

    public function setMinistry(string $ministry): self
    {
        $this->ministry = $ministry;

        return $this;
    }

    public function getOffice(): ?string
    {
        return $this->office;
    }

    public function setOffice(string $office): self
    {
        $this->office = $office;

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

    public function getDirector(): ?string
    {
        return $this->director;
    }

    public function setDirector(string $director): self
    {
        $this->director = $director;

        return $this;
    }

    public function getEconomist(): ?string
    {
        return $this->economist;
    }

    public function setEconomist(string $economist): self
    {
        $this->economist = $economist;

        return $this;
    }

    public function getAdministrator(): ?string
    {
        return $this->administrator;
    }

    public function setAdministrator(string $administrator): self
    {
        $this->administrator = $administrator;

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

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

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

    public function getFax(): ?int
    {
        return $this->fax;
    }

    public function setFax(int $fax): self
    {
        $this->fax = $fax;

        return $this;
    }

    public function getYear(): ?string
    {
        return $this->year;
    }

    public function setYear(string $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
