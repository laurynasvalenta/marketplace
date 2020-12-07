<?php

namespace App\Validator;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class AvailableQuantityValidator extends ConstraintValidator
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * @param OrderRepository $orderRepository
     */
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * {@inheritDoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof AvailableQuantity) {
            throw new UnexpectedTypeException($constraint, AvailableQuantity::class);
        }

        if (!$value instanceof Order) {
            return;
        }

        $previouslyOrderedQuantity = $this->orderRepository->sumOrderedQuantity($value->getProductUuid());

        if ($previouslyOrderedQuantity + $value->getOrderQuantity() > $value->getProductQuantity()) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
