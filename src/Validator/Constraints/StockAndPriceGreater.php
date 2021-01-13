<?php

declare(strict_types=1);

namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * Class StockAndPriceGreater
 * @Annotation
 * @package App\Validator\Constraints
 */
class StockAndPriceGreater extends Constraint
{
    const ITEM_MIN_PRICE = 5;
    const ITEM_MIN_STOCK = 10;
    public $message = "stock must be more than " . self::ITEM_MIN_STOCK .
    " or cost must be more than " . self::ITEM_MIN_PRICE . "$";

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
