<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ExittRepository")
 */
class Exitt
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
     * @ORM\Column(type="string", length=255)
     */
    private $number;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Employee", inversedBy="exitts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $employee;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LineExitt", mappedBy="exitt",cascade={"persist"}, orphanRemoval=true)
     */
    private $lineExitts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Journal", mappedBy="exitt",cascade={"persist"}, orphanRemoval=true)
     */
    private $journals;

    /**
     * @ORM\Column(type="decimal", precision=15, scale=3)
     */
    private $totalPrice;

    public function __construct()
    {
        $this->lineExitts = new ArrayCollection();
        $this->journals = new ArrayCollection();
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

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }
    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): self
    {
        $this->employee = $employee;

        return $this;
    }

    /**
     * @return Collection|LineExitt[]
     */
    public function getLineExitts(): Collection
    {
        return $this->lineExitts;
    }

    public function addLineExitt(LineExitt $lineExitt): self
    {
        if (!$this->lineExitts->contains($lineExitt)) {
            $this->lineExitts[] = $lineExitt;
            $lineExitt->setExitt($this);
        }

        return $this;
    }

    public function removeLineExitt(LineExitt $lineExitt): self
    {
        if ($this->lineExitts->contains($lineExitt)) {
            $this->lineExitts->removeElement($lineExitt);
            // set the owning side to null (unless already changed)
            if ($lineExitt->getExitt() === $this) {
                $lineExitt->setExitt(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
       return $this-> totalPrice; // TODO: Implement __toString() method.
       // return $this-> number;
    }

    /**
     * @return Collection|Journal[]
     */
    public function getJournals(): Collection
    {
        return $this->journals;
    }

    public function addJournal(Journal $journal): self
    {
        if (!$this->journals->contains($journal)) {
            $this->journals[] = $journal;
            $journal->setExitt($this);
        }

        return $this;
    }

    public function removeJournal(Journal $journal): self
    {
        if ($this->journals->contains($journal)) {
            $this->journals->removeElement($journal);
            // set the owning side to null (unless already changed)
            if ($journal->getExitt() === $this) {
                $journal->setExitt(null);
            }
        }

        return $this;
    }

    public function getTotalPrice(): ?string
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(string $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }
}
