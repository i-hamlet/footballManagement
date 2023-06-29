<?php

declare(strict_types=1);

namespace App\DTO;

readonly class TransferData
{
    public function __construct(
        private int $sellerId,
        private int $buyerId,
        private int $playerId,
        private float $price
    )
    {}

    /**
     * @return int
     */
    public function getSellerId(): int
    {
        return $this->sellerId;
    }

    /**
     * @return int
     */
    public function getBuyerId(): int
    {
        return $this->buyerId;
    }

    /**
     * @return int
     */
    public function getPlayerId(): int
    {
        return $this->playerId;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    public function toArray(): array
    {
        return [
            'buyerId' => $this->buyerId,
            'sellerId' => $this->sellerId,
            'playerId' => $this->playerId,
            'price' => $this->price,
        ];
    }
}