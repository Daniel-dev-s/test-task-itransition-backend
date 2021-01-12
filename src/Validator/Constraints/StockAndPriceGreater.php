<?php


namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * Class StockAndPriceGreater
 * @Annotation
 * @package App\Validator\Constraints
 */
class StockAndPriceGreater extends Constraint
{
    // mimimum accepted item price
    const ITEM_MIN_PRICE = 5;
    // minimum accepted item stock
    const ITEM_MIN_STOCK = 10;

    public $message = "stock must be more than " . self::ITEM_MIN_STOCK .
    " or cost must be more than " . self::ITEM_MIN_PRICE . "$";

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
