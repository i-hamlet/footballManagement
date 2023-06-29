<?php

declare(strict_types=1);

namespace App\DTO;


readonly class TeamData
{
    public function __construct(
        private string $name,
        private string $country,
        private float $balance,
    )
    {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'country' => $this->country,
            'balance' => $this->balance,
        ];
    }
}