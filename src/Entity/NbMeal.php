<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NbMealRepository")
 */
class NbMeal
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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $std_resident;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $std_semiResident;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $std_granted;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $professor;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $employee;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $curators;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Journal", mappedBy="nbMeal")
     */
    private $journals;

    public function __construct()
    {
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

    public function getStdResident(): ?int
    {
        return $this->std_resident;
    }

    public function setStdResident(int $std_resident): self
    {
        $this->std_resident = $std_resident;

        return $this;
    }

    public function getStdSemiResident(): ?int
    {
        return $this->std_semiResident;
    }

    public function setStdSemiResident(int $std_semiResident): self
    {
        $this->std_semiResident = $std_semiResident;

        return $this;
    }

    public function getStdGranted(): ?int
    {
        return $this->std_granted;
    }

    public function setStdGranted(int $std_granted): self
    {
        $this->std_granted = $std_granted;

        return $this;
    }

    public function getProfessor(): ?int
    {
        return $this->professor;
    }

    public function setProfessor(int $professor): self
    {
        $this->professor = $professor;

        return $this;
    }

    public function getEmployee(): ?int
    {
        return $this->employee;
    }

    public function setEmployee(int $employee): self
    {
        $this->employee = $employee;

        return $this;
    }

    public function getCurators(): ?int
    {
        return $this->curators;
    }

    public function setCurators(int $curators): self
    {
        $this->curators = $curators;

        return $this;
    }
    public function __toString()
    {
	     $calc = $this->std_resident + $this->std_granted + $this->std_semiResident + $this->professor + $this->employee + $this->curators;
         return  (string)$calc;
        /*$calc = $this->std_resident + $this->std_granted + $this->std_semiResident;
        return  (string)$calc;*/
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
            $journal->setNbMeal($this);
        }

        return $this;
    }

    public function removeJournal(Journal $journal): self
    {
        if ($this->journals->contains($journal)) {
            $this->journals->removeElement($journal);
            // set the owning side to null (unless already changed)
            if ($journal->getNbMeal() === $this) {
                $journal->setNbMeal(null);
            }
        }

        return $this;
    }

}
