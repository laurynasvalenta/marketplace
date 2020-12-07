<?php

namespace App\Validator;

use App\Entity\Order;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class CorrectOwnerValidator extends ConstraintValidator
{
    /**
     * {@inheritDoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof CorrectOwner) {
            throw new UnexpectedTypeException($constraint, CorrectOwner::class);
        }

        if (!$value instanceof Order) {
            return;
        }

        if ($value->getOwnerUuid() === $value->getProductOwnerUuid()) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
