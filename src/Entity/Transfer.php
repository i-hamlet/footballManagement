<?php

namespace App\Entity;

use App\Repository\TransferRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransferRepository::class)]
class Transfer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'transfers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Team $seller = null;

    #[ORM\ManyToOne(inversedBy: 'transfers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Team $buyer = null;

    #[ORM\ManyToOne(inversedBy: 'transfers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Player $player = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 14, scale: 2)]
    private ?float $price = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSeller(): ?Team
    {
        return $this->seller;
    }

    public function setSeller(?Team $seller): static
    {
        $this->seller = $seller;

        return $this;
    }

    public function getBuyer(): ?Team
    {
        return $this->buyer;
    }

    public function setBuyer(?Team $buyer): static
    {
        $this->buyer = $buyer;

        return $this;
    }

    public function setPlayer(?Player $player): static
    {
        $this->player = $player;

        return $this;
    }

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }
}
