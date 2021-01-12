<?php


namespace App\DTO;

use App\Validator\Constraints as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ItemDTO
 * @package App\DTO
 * @AppAssert\StockAndPriceGreater()
 */
class ItemDTO
{
    // maximum accepted item price
    const ITEM_MAX_PRICE = 1000;

    /**
     * @var string|null
     * @Assert\NotBlank()
     */
    private ?string $productCode;

    /**
     * @var string|null
     * @Assert\NotBlank()
     */
    private ?string $productName;

    /**
     * @var string|null
     * @Assert\NotBlank()
     */
    private ?string $description;

    /**
     * @var int|null
     * @Assert\NotBlank()
     */
    private ?int $stock;

    /**
     * @var float|null
     * @Assert\LessThan(self::ITEM_MAX_PRICE)
     * @Assert\NotBlank()
     */
    private ?float $cost;

    private ?bool $discontinued;

    /**
     * ItemDTO constructor.
     * @param string|null $productCode
     * @param string|null $productName
     * @param string|null $description
     * @param int|null $stock
     * @param float|null $cost
     * @param bool|null $discontinued
     */
    public function __construct(?string $productCode, ?string $productName, ?string $description, ?int $stock, ?float $cost, ?bool $discontinued)
    {
        $this->productCode = $productCode;
        $this->productName = $productName;
        $this->description = $description;
        $this->stock = $stock;
        $this->cost = $cost;
        $this->discontinued = $discontinued;
    }

    /**
     * @return string|null
     */
    public function getProductCode(): ?string
    {
        return $this->productCode;
    }

    /**
     * @return string|null
     */
    public function getProductName(): ?string
    {
        return $this->productName;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return int|null
     */
    public function getStock(): ?int
    {
        return $this->stock;
    }

    /**
     * @return float|null
     */
    public function getCost(): ?float
    {
        return $this->cost;
    }

    /**
     * @return bool|null
     */
    public function getDiscontinued(): ?bool
    {
        return $this->discontinued;
    }

    /**
     * @param string|null $productCode
     */
    public function setProductCode(?string $productCode): void
    {
        $this->productCode = $productCode;
    }

    /**
     * @param string|null $productName
     */
    public function setProductName(?string $productName): void
    {
        $this->productName = $productName;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @param int|null $stock
     */
    public function setStock(?int $stock): void
    {
        $this->stock = $stock;
    }

    /**
     * @param float|null $cost
     */
    public function setCost(?float $cost): void
    {
        $this->cost = $cost;
    }

    /**
     * @param bool|null $discontinued
     */
    public function setDiscontinued(?bool $discontinued): void
    {
        $this->discontinued = $discontinued;
    }


}
