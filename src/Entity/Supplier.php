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
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="string")
     */
    private $site;

    /**
     * @ORM\Column(type="string")
     */
    private $address;

    /**
     * @ORM\Column(type="string")
     */
    private $distance;

    /**
     * @ORM\Column(type="text")
     */
    private $requisites;

    /**
     * @ORM\Column(type="text")
     */
    private $comment;

    public function __construct()
    {
        $this->staffers = new ArrayCollection();
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
}