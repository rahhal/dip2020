<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmployeeRepository")
 */
class Employee
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $activity;

    /**
     * @ORM\Column(type="integer")
     */
    private $phone;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Exitt", mappedBy="employee", orphanRemoval=true)
     */
    private $exitts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commission", mappedBy="employee", orphanRemoval=true)
     */
    private $commissions;
/**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="employees")
     */
    private $user;

    public function __construct()
    {
        $this->exitts = new ArrayCollection();
        $this->commissions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function __toString()
    {
        return $this-> name;}

    /**
     * @return Collection|Exitt[]
     */
    public function getExitts(): Collection
    {
        return $this->exitts;
    }

    public function addExitt(Exitt $exitt): self
    {
        if (!$this->exitts->contains($exitt)) {
            $this->exitts[] = $exitt;
            $exitt->setEmployee($this);
        }

        return $this;
    }

    public function removeExitt(Exitt $exitt): self
    {
        if ($this->exitts->contains($exitt)) {
            $this->exitts->removeElement($exitt);
            // set the owning side to null (unless already changed)
            if ($exitt->getEmployee() === $this) {
                $exitt->setEmployee(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Commission[]
     */
    public function getCommissions(): Collection
    {
        return $this->commissions;
    }

    public function addCommission(Commission $commission): self
    {
        if (!$this->commissions->contains($commission)) {
            $this->commissions[] = $commission;
            $commission->setEmployee($this);
        }

        return $this;
    }

    public function removeCommission(Commission $commission): self
    {
        if ($this->commissions->contains($commission)) {
            $this->commissions->removeElement($commission);
            // set the owning side to null (unless already changed)
            if ($commission->getEmployee() === $this) {
                $commission->setEmployee(null);
            }
        }

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
