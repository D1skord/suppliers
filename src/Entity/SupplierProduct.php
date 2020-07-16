<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * @ORM\Entity()
 */
class SupplierProduct
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="Supplier", inversedBy="products")
     */
    private $supplier;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $height;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $countMin;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $countMax;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $diameterBarrel;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $diameterCrown;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $diameterComa;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

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

    public function getHeight(): ?string
    {
        return $this->height;
    }

    public function setHeight(?string $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCountMin(): ?string
    {
        return $this->countMin;
    }

    public function setCountMin(?string $countMin): self
    {
        $this->countMin = $countMin;

        return $this;
    }

    public function getCountMax(): ?string
    {
        return $this->countMax;
    }

    public function setCountMax(?string $countMax): self
    {
        $this->countMax = $countMax;

        return $this;
    }

    public function getDiameterBarrel(): ?string
    {
        return $this->diameterBarrel;
    }

    public function setDiameterBarrel(?string $diameterBarrel): self
    {
        $this->diameterBarrel = $diameterBarrel;

        return $this;
    }

    public function getDiameterCrown(): ?string
    {
        return $this->diameterCrown;
    }

    public function setDiameterCrown(?string $diameterCrown): self
    {
        $this->diameterCrown = $diameterCrown;

        return $this;
    }

    public function getDiameterComa(): ?string
    {
        return $this->diameterComa;
    }

    public function setDiameterComa(?string $diameterComa): self
    {
        $this->diameterComa = $diameterComa;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getSupplier(): ?Supplier
    {
        return $this->supplier;
    }

    public function setSupplier(?Supplier $supplier): self
    {
        $this->supplier = $supplier;

        return $this;
    }
}