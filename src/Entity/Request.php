<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Request
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Завершена ли заявка?
     *
     * @ORM\Column(type="boolean", options={"default":"0"})
     */
    private $completed;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RequestItem", mappedBy="request", cascade={"persist", "remove"})
     */
    private $items;

    /**
     * @ORM\Column(type="date", nullable=false)
     */
    private $date;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->items = new ArrayCollection();
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
        }

        return $this;
    }

    public function removeProduct(SupplierProduct $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
        }

        return $this;
    }

    /**
     * @return Collection|RequestItem[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(RequestItem $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setRequest($this);
        }

        return $this;
    }

    public function removeItem(RequestItem $item): self
    {
        if ($this->items->contains($item)) {
            $this->items->removeElement($item);
            // set the owning side to null (unless already changed)
            if ($item->getRequest() === $this) {
                $item->setRequest(null);
            }
        }

        return $this;
    }

    public function getCompleted(): ?bool
    {
        return $this->completed;
    }

    public function setCompleted(bool $completed): self
    {
        $this->completed = $completed;

        return $this;
    }
}