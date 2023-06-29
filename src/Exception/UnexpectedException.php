<?php

declare(strict_types=1);

namespace App\Exception;

class UnexpectedException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Something went wrong, please try again later');
    }
}