<?php

declare(strict_types=1);

namespace App\Exception;

class RecordAlreadyExistException extends \Exception
{
    public function __construct(array $constraints)
    {
        $firstConstraintKey = key($constraints);
        $firstConstraintValue = $constraints[$firstConstraintKey];
        unset($constraints[$firstConstraintKey]);
        $message = "Record with $firstConstraintKey: $firstConstraintValue ";
        if (count($constraints) > 0) {
            foreach ($constraints as $key => $value) {
                $message .= "and $key: $value ";
            }
        }
        $message .= 'already exist';

        parent::__construct($message);
    }
}