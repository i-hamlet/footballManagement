<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\Validator\ConstraintViolationList;

class InputValidationException extends \Exception
{
    private array $errors = [];

    public function __construct(ConstraintViolationList $constraintViolations)
    {
        parent::__construct('Invalid input data');

        foreach ($constraintViolations as $constraintViolation) {
            $this->errors[$constraintViolation->getPropertyPath()] = $constraintViolation->getMessage();
        }
    }

    public function toArray(): array
    {
        return $this->errors;
    }
}