<?php

declare(strict_types=1);

namespace Application\Services\Validator;

use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class Errors
 * @package Application\Services\Validator
 */
class Errors
{
    /**
     * @var ConstraintViolationListInterface
     */
    private $violations;

    public function __construct(ConstraintViolationListInterface $violations)
    {
        $this->violations = $violations;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $errors = [];
        foreach ($this->violations as $violation) {
            $errors[$violation->getPropertyPath()] = $violation->getMessage();
        }

        return $errors;
    }
}
