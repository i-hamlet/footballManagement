<?php

declare(strict_types=1);

namespace App\DTO;

use Symfony\Component\HttpFoundation\Request;
use Webmozart\Assert\Assert;

readonly class PlayerData
{
    public function __construct(
        private string $firstName,
        private string $lastName,
        private int $teamId,
    )
    {}

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getTeamId(): int
    {
        return $this->teamId;
    }

    public function toArray(): array
    {
        return [
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'teamId' => $this->teamId,
        ];
    }
}