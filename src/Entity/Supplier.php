<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity()
 * @UniqueEntity(fields={"email"}, message="Поставщик с таким email уже зарегистрирован!")
 */
class Supplier
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="SupplierStaffer", mappedBy="supplier", cascade={"persist", "remove"})
     */
    private $staffers;

    /**
     * @ORM\OneToMany(targetEntity="SupplierProduct", mappedBy="supplier", cascade={"persist", "remove"})
     */
    private $products;

    /**
     * @ORM\ManyToOne(targetEntity="SupplierRegion")
     */
    private $region;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $site;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $distance;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $requisites;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    public function __construct()
    {
        $this->staffers = new ArrayCollection();
        $this->products = new ArrayCollection();
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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
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

    public function getSite(): ?string
    {
        return $this->site;
    }

    public function setSite(string $site): self
    {
        $this->site = $site;

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

    public function getDistance(): ?string
    {
        return $this->distance;
    }

    public function setDistance(string $distance): self
    {
        $this->distance = $distance;

        return $this;
    }

    public function getRequisites(): ?string
    {
        return $this->requisites;
    }

    public function setRequisites(string $requisites): self
    {
        $this->requisites = $requisites;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return Collection|SupplierStaffer[]
     */
    public function getStaffers(): Collection
    {
        return $this->staffers;
    }

    public function addStaffer(SupplierStaffer $staffer): self
    {
        if (!$this->staffers->contains($staffer)) {
            $this->staffers[] = $staffer;
            $staffer->setSupplier($this);
        }

        return $this;
    }

    public function removeStaffer(SupplierStaffer $staffer): self
    {
        if ($this->staffers->contains($staffer)) {
            $this->staffers->removeElement($staffer);
            // set the owning side to null (unless already changed)
            if ($staffer->getSupplier() === $this) {
                $staffer->setSupplier(null);
            }
        }

        return $this;
    }

    public function getStaffer($id)
    {
        foreach ($this->staffers as $staffer) {
            if ($staffer->getId() == $id) {
                return $staffer;
            }
        }

        return null;
    }

    public function getProduct($id)
    {
        foreach ($this->products as $product) {
            if ($product->getId() == $id) {
                return $product;
            }
        }

        return null;
    }

    /**
     * @return Collection|SupplierProduct[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(SupplierProduct $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setSupplier($this);
        }

        return $this;
    }

    public function removeProduct(SupplierProduct $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getSupplier() === $this) {
                $product->setSupplier(null);
            }
        }

        return $this;
    }

    public function getRegion(): ?SupplierRegion
    {
        return $this->region;
    }

    public function setRegion(?SupplierRegion $region): self
    {
        $this->region = $region;

        return $this;
    }
}