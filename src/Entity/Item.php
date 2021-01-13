<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ItemRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ItemRepository::class)
 */
class Item
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private string $productCode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $productName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $description;

    /**
     * @ORM\Column(type="integer")
     */
    private int $stock;

    /**
     * @ORM\Column(type="float")
     */
    private float $cost;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $discontinued;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private ?DateTime $discontinuedDate;

    /**
     * Item constructor.
     * @param string $productCode
     * @param string $productName
     * @param string $description
     * @param int $stock
     * @param float $cost
     * @param bool $discontinued
     */
    public function __construct(string $productCode,
                                string $productName,
                                string $description,
                                int $stock,
                                float $cost,
                                bool $discontinued){
        $this->productCode = $productCode;
        $this->productName = $productName;
        $this->description = $description;
        $this->stock = $stock;
        $this->cost = $cost;
        $this->discontinued = $discontinued;
        $this->setDiscontinuedDate($discontinued ? new DateTime() : null);
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductCode(): ?string
    {
        return $this->productCode;
    }

    public function setProductCode(string $ProductCode): self
    {
        $this->productCode = $ProductCode;

        return $this;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(string $ProductName): self
    {
        $this->productName = $ProductName;

        return $this;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $Description): self
    {
        $this->description = $Description;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $Stock): self
    {
        $this->stock = $Stock;

        return $this;
    }

    public function getCost(): ?float
    {
        return $this->cost;
    }

    public function setCost(float $Cost): self
    {
        $this->cost = $Cost;

        return $this;
    }

    public function getDiscontinued(): ?bool
    {
        return $this->discontinued;
    }

    public function setDiscontinued(bool $Discontinued): self
    {
        $this->discontinued = $Discontinued;

        return $this;
    }

    public function __toString(): string
    {
        return "[$this->productCode] $this->productName ($this->description) ($this->stock) $this->cost$" .
            ($this->discontinued == 1 ?
                " <discontinued from " . $this->discontinuedDate->format('y-m-d') . '>'
                : '');
    }

    public function getDiscontinuedDate(): ?DateTime
    {
        return $this->discontinuedDate;
    }

    public function setDiscontinuedDate(?DateTime $discontinuedDate): self
    {
        $this->discontinuedDate = $discontinuedDate;

        return $this;
    }
}
