<?php

declare(strict_types=1);

namespace App\DTO;


use App\Entity\Item;

class ParsedItems
{
    private array $successItems;
    private array $failedItems;

    public function __construct()
    {
        $this->successItems = array();
        $this->failedItems = array();
    }

    /**
     * @return array
     */
    public function getSuccessItems(): array
    {
        return $this->successItems;
    }

    /**
     * @param array $successItems
     */
    public function setSuccessItems(array $successItems): void
    {
        $this->successItems = $successItems;
    }

    public function pushIntoSuccessItems(Item $item)
    {
        array_push($this->successItems, $item);
    }
    public function pushIntoFailedItems(?string $item)
    {
        array_push($this->failedItems, $item);
    }

    /**
     * @return array
     */
    public function getFailedItems(): array
    {
        return $this->failedItems;
    }

    /**
     * @param array $failedItems
     */
    public function setFailedItems(array $failedItems): void
    {
        $this->failedItems = $failedItems;
    }


}
