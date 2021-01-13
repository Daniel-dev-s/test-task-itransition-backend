<?php

declare(strict_types=1);

namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @Annotation
 * @package App\Validator
 */
class StockAndPriceGreaterValidator extends ConstraintValidator
{
    const ITEM_MIN_PRICE = 5;
    const ITEM_MIN_STOCK = 10;

    public function validate($value, Constraint $constraint)
    {
        if ($value->getCost() < self::ITEM_MIN_PRICE && $value->getStock() < self::ITEM_MIN_STOCK)
        {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
