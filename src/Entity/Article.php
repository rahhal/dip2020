<?php

namespace App\Entity;

use App\Repository\LineStockRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 * @UniqueEntity(fields={"name"})
 * @UniqueEntity(fields={"reference_stock"})
 */
class Article
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
     * @ORM\Column(type="string", length=255, nullable=true)
     * * @Assert\Length(max=10)
     */
    private $unit;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="articles")
     */
    private $Category;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LinePurchase", mappedBy="article", cascade={"persist"}, orphanRemoval=true)
     */
    private $linePurchases;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LineExitt", mappedBy="article", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $lineExitts;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reference_stock;


    /**
     * @ORM\Column(type="integer")
     */
    private $ini_qty;

    /**
     * @ORM\Column(type="integer")
     */
    private $min_qty;

    /**
     * @ORM\Column(type="date")
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LineInventory", mappedBy="article")
     */
    private $lineInventories;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LineDemand", mappedBy="article")
     */
    private $lineDemands;



    public function __construct()
    {
        $this->linePurchases = new ArrayCollection();
        $this->lineExitts = new ArrayCollection();
        $this->lineInventories = new ArrayCollection();
        $this->lineDemands = new ArrayCollection();
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

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): self
    {
        $this->unit = $unit;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->Category;
    }

    public function setCategory(?Category $Category): self
    {
        $this->Category = $Category;

        return $this;
    }

    /**
     * @return Collection|LinePurchase[]
     */
    public function getLinePurchases(): Collection
    {
        return $this->linePurchases;
    }

    public function addLinePurchase(LinePurchase $linePurchase): self
    {
        if (!$this->linePurchases->contains($linePurchase)) {
            $this->linePurchases[] = $linePurchase;
            $linePurchase->setArticle($this);
        }

        return $this;
    }

    public function removeLinePurchase(LinePurchase $linePurchase): self
    {
        if ($this->linePurchases->contains($linePurchase)) {
            $this->linePurchases->removeElement($linePurchase);
            // set the owning side to null (unless already changed)
            if ($linePurchase->getArticle() === $this) {
                $linePurchase->setArticle(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection|LineExitt[]
     */
    public function getLineExitts(): Collection
    {
        return $this->linePurchases;
    }

    public function addLineExitt(LineExitt $lineExitt): self
    {
        if (!$this->lineExitts->contains($lineExitt)) {
            $this->lineExitts[] = $lineExitt;
            $lineExitt->setArticle($this);
        }

        return $this;
    }

    public function removeLineExitt(LineExitt $lineExitt): self
    {
        if ($this->lineExitts->contains($lineExitt)) {
            $this->lineExitts->removeElement($lineExitt);
            // set the owning side to null (unless already changed)
            if ($lineExitt->getArticle() === $this) {
                $lineExitt->setArticle(null);
            }
        }

        return $this;
    }



    public function getReferenceStock(): ?string
    {
        return $this->reference_stock;
    }

    public function setReferenceStock(string $reference_stock): self
    {
        $this->reference_stock = $reference_stock;

        return $this;
    }

    public function getIniQty(): ?int
    {
        return $this->ini_qty;
    }

    public function setIniQty(int $ini_qty): self
    {
        $this->ini_qty = $ini_qty;

        return $this;
    }

    public function getMinQty(): ?int
    {
        return $this->min_qty;
    }

    public function setMinQty(int $min_qty): self
    {
        $this->min_qty = $min_qty;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
    public function __toString()
    {
        // TODO: Implement __toString() method.
        return  $this->name;
    }

    /**
     * @return Collection|LineInventory[]
     */
    public function getLineInventories(): Collection
    {
        return $this->lineInventories;
    }

    public function addLineInventory(LineInventory $lineInventory): self
    {
        if (!$this->lineInventories->contains($lineInventory)) {
            $this->lineInventories[] = $lineInventory;
            $lineInventory->setArticle($this);
        }

        return $this;
    }

    public function removeLineInventory(LineInventory $lineInventory): self
    {
        if ($this->lineInventories->contains($lineInventory)) {
            $this->lineInventories->removeElement($lineInventory);
            // set the owning side to null (unless already changed)
            if ($lineInventory->getArticle() === $this) {
                $lineInventory->setArticle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|LineDemand[]
     */
    public function getLineDemands(): Collection
    {
        return $this->lineDemands;
    }

    public function addLineDemand(LineDemand $lineDemand): self
    {
        if (!$this->lineDemands->contains($lineDemand)) {
            $this->lineDemands[] = $lineDemand;
            $lineDemand->setArticle($this);
        }

        return $this;
    }

    public function removeLineDemand(LineDemand $lineDemand): self
    {
        if ($this->lineDemands->contains($lineDemand)) {
            $this->lineDemands->removeElement($lineDemand);
            // set the owning side to null (unless already changed)
            if ($lineDemand->getArticle() === $this) {
                $lineDemand->setArticle(null);
            }
        }

        return $this;
    }

}
