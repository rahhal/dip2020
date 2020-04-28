<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"})
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $company;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $director;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="text", nullable=true, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fullname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $RIB;

    /**
     * @var string le token qui servira lors de l'oubli de mot de passe
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $resetToken;
      /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="user", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $articles;
     /**
     * @ORM\OneToMany(targetEntity="App\Entity\Category", mappedBy="user", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $categories;

     /**
     * @ORM\OneToMany(targetEntity="App\Entity\Institution", mappedBy="user", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $institutions;
      /**
     * @ORM\OneToMany(targetEntity="App\Entity\Supplier", mappedBy="user", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $suppliers;
     /**
     * @ORM\OneToMany(targetEntity="App\Entity\Employee", mappedBy="user", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $employees;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Demand", mappedBy="user", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $demands;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commission", mappedBy="user", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $commissions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Purchase", mappedBy="user", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $purchases;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Stock", mappedBy="user", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $stocks;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Menu", mappedBy="user", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $menus;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\NbMeal", mappedBy="user", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $nbMeals;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LineStock", mappedBy="user", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $lineStocks;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Inventory", mappedBy="user", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $inventories;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Exitt", mappedBy="user", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $exitts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Journal", mappedBy="user", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $journals;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->institution = new ArrayCollection();
        $this->institutions = new ArrayCollection();
        $this->suppliers = new ArrayCollection();
        $this->employees = new ArrayCollection();
        $this->demands = new ArrayCollection();
        $this->commissions = new ArrayCollection();
        $this->purchases = new ArrayCollection();
        $this->stocks = new ArrayCollection();
        $this->menus = new ArrayCollection();
        $this->nbMeals = new ArrayCollection();
        $this->lineStocks = new ArrayCollection();
        $this->inventories = new ArrayCollection();
        $this->exitts = new ArrayCollection();
        $this->journals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(string $company): self
    {
        $this->company = $company;

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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

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

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(?string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }

    public function getRIB(): ?string
    {
        return $this->RIB;
    }

    public function setRIB(string $RIB): self
    {
        $this->RIB = $RIB;

        return $this;
    }
    /**
     * @return string
     */
    public function getResetToken(): string
    {
        return $this->resetToken;
    }

    /**
     * @param string $resetToken
     */
    public function setResetToken(?string $resetToken): void
    {
        $this->resetToken = $resetToken;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setUser($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
            // set the owning side to null (unless already changed)
            if ($article->getUser() === $this) {
                $article->setUser(null);
            }
        }

        return $this;
    }
    
    public function __toString()
    {
        // TODO: Implement __toString() method.
        return  $this-> email;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->setUser($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
            // set the owning side to null (unless already changed)
            if ($category->getUser() === $this) {
                $category->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Institution[]
     */
    public function getInstitutions(): Collection
    {
        return $this->institutions;
    }

    public function addInstitution(Institution $institution): self
    {
        if (!$this->institutions->contains($institution)) {
            $this->institutions[] = $institution;
            $institution->setUser($this);
        }

        return $this;
    }

    public function removeInstitution(Institution $institution): self
    {
        if ($this->institutions->contains($institution)) {
            $this->institutions->removeElement($institution);
            // set the owning side to null (unless already changed)
            if ($institution->getUser() === $this) {
                $institution->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Supplier[]
     */
    public function getSuppliers(): Collection
    {
        return $this->suppliers;
    }

    public function addSupplier(Supplier $supplier): self
    {
        if (!$this->suppliers->contains($supplier)) {
            $this->suppliers[] = $supplier;
            $supplier->setUser($this);
        }

        return $this;
    }

    public function removeSupplier(Supplier $supplier): self
    {
        if ($this->suppliers->contains($supplier)) {
            $this->suppliers->removeElement($supplier);
            // set the owning side to null (unless already changed)
            if ($supplier->getUser() === $this) {
                $supplier->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Employee[]
     */
    public function getEmployees(): Collection
    {
        return $this->employees;
    }

    public function addEmployee(Employee $employee): self
    {
        if (!$this->employees->contains($employee)) {
            $this->employees[] = $employee;
            $employee->setUser($this);
        }

        return $this;
    }

    public function removeEmployee(Employee $employee): self
    {
        if ($this->employees->contains($employee)) {
            $this->employees->removeElement($employee);
            // set the owning side to null (unless already changed)
            if ($employee->getUser() === $this) {
                $employee->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Demand[]
     */
    public function getDemands(): Collection
    {
        return $this->demands;
    }

    public function addDemand(Demand $demand): self
    {
        if (!$this->demands->contains($demand)) {
            $this->demands[] = $demand;
            $demand->setUser($this);
        }

        return $this;
    }

    public function removeDemand(Demand $demand): self
    {
        if ($this->demands->contains($demand)) {
            $this->demands->removeElement($demand);
            // set the owning side to null (unless already changed)
            if ($demand->getUser() === $this) {
                $demand->setUser(null);
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
            $commission->setUser($this);
        }

        return $this;
    }

    public function removeCommission(Commission $commission): self
    {
        if ($this->commissions->contains($commission)) {
            $this->commissions->removeElement($commission);
            // set the owning side to null (unless already changed)
            if ($commission->getUser() === $this) {
                $commission->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Purchase[]
     */
    public function getPurchases(): Collection
    {
        return $this->purchases;
    }

    public function addPurchase(Purchase $purchase): self
    {
        if (!$this->purchases->contains($purchase)) {
            $this->purchases[] = $purchase;
            $purchase->setUser($this);
        }

        return $this;
    }

    public function removePurchase(Purchase $purchase): self
    {
        if ($this->purchases->contains($purchase)) {
            $this->purchases->removeElement($purchase);
            // set the owning side to null (unless already changed)
            if ($purchase->getUser() === $this) {
                $purchase->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Stock[]
     */
    public function getStocks(): Collection
    {
        return $this->stocks;
    }

    public function addStock(Stock $stock): self
    {
        if (!$this->stocks->contains($stock)) {
            $this->stocks[] = $stock;
            $stock->setUser($this);
        }

        return $this;
    }

    public function removeStock(Stock $stock): self
    {
        if ($this->stocks->contains($stock)) {
            $this->stocks->removeElement($stock);
            // set the owning side to null (unless already changed)
            if ($stock->getUser() === $this) {
                $stock->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Menu[]
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
            $menu->setUser($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->contains($menu)) {
            $this->menus->removeElement($menu);
            // set the owning side to null (unless already changed)
            if ($menu->getUser() === $this) {
                $menu->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|NbMeal[]
     */
    public function getNbMeals(): Collection
    {
        return $this->nbMeals;
    }

    public function addNbMeal(NbMeal $nbMeal): self
    {
        if (!$this->nbMeals->contains($nbMeal)) {
            $this->nbMeals[] = $nbMeal;
            $nbMeal->setUser($this);
        }

        return $this;
    }

    public function removeNbMeal(NbMeal $nbMeal): self
    {
        if ($this->nbMeals->contains($nbMeal)) {
            $this->nbMeals->removeElement($nbMeal);
            // set the owning side to null (unless already changed)
            if ($nbMeal->getUser() === $this) {
                $nbMeal->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|LineStock[]
     */
    public function getLineStocks(): Collection
    {
        return $this->lineStocks;
    }

    public function addLineStock(LineStock $lineStock): self
    {
        if (!$this->lineStocks->contains($lineStock)) {
            $this->lineStocks[] = $lineStock;
            $lineStock->setUser($this);
        }

        return $this;
    }

    public function removeLineStock(LineStock $lineStock): self
    {
        if ($this->lineStocks->contains($lineStock)) {
            $this->lineStocks->removeElement($lineStock);
            // set the owning side to null (unless already changed)
            if ($lineStock->getUser() === $this) {
                $lineStock->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Inventory[]
     */
    public function getInventories(): Collection
    {
        return $this->inventories;
    }

    public function addInventory(Inventory $inventory): self
    {
        if (!$this->inventories->contains($inventory)) {
            $this->inventories[] = $inventory;
            $inventory->setUser($this);
        }

        return $this;
    }

    public function removeInventory(Inventory $inventory): self
    {
        if ($this->inventories->contains($inventory)) {
            $this->inventories->removeElement($inventory);
            // set the owning side to null (unless already changed)
            if ($inventory->getUser() === $this) {
                $inventory->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|exitt[]
     */
    public function getExitts(): Collection
    {
        return $this->exitts;
    }

    public function addExitt(exitt $exitt): self
    {
        if (!$this->exitts->contains($exitt)) {
            $this->exitts[] = $exitt;
            $exitt->setUser($this);
        }

        return $this;
    }

    public function removeExitt(exitt $exitt): self
    {
        if ($this->exitts->contains($exitt)) {
            $this->exitts->removeElement($exitt);
            // set the owning side to null (unless already changed)
            if ($exitt->getUser() === $this) {
                $exitt->setUser(null);
            }
        }

        return $this;
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
            $journal->setUser($this);
        }

        return $this;
    }

    public function removeJournal(Journal $journal): self
    {
        if ($this->journals->contains($journal)) {
            $this->journals->removeElement($journal);
            // set the owning side to null (unless already changed)
            if ($journal->getUser() === $this) {
                $journal->setUser(null);
            }
        }

        return $this;
    }
}
