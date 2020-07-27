<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SupplierProductRepository")
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
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SupplierProductType")
     */
    private $type;

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

    /**
     * @ORM\ManyToOne(targetEntity="SupplierProductRoot")
     */
    private $root;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $containerSize;


    /**
     * @ManyToOne(targetEntity="Supplier", inversedBy="products")
     */
    private $supplier;

    /**
     * @ORM\Column(type="date", nullable=false)
     */
    private $date;


    public function __construct()
    {
        $this->setDate(new \DateTime());
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getRoot(): ?SupplierProductRoot
    {
        return $this->root;
    }

    public function setRoot(?SupplierProductRoot $root): self
    {
        $this->root = $root;

        return $this;
    }

    public function getType(): ?SupplierProductType
    {
        return $this->type;
    }

    public function setType(?SupplierProductType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getContainerSize(): ?string
    {
        return $this->containerSize;
    }

    public function setContainerSize(string $containerSize): self
    {
        $this->containerSize = $containerSize;

        return $this;
    }
}