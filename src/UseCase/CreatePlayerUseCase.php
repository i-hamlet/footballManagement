<?php

declare(strict_types=1);

namespace App\UseCase;

use App\DTO\PlayerData;
use App\Entity\Player;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;

readonly class CreatePlayerUseCase
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private TeamRepository $teamRepository

    ){}

    public function execute(PlayerData $playerData): Player
    {
        $team = $this->teamRepository->find($playerData->getTeamId());
        $player = new Player();
        $player->setFirstName($playerData->getFirstName());
        $player->setLastName($playerData->getLastName());
        $player->setTeam($team);

        $this->entityManager->persist($player);
        $this->entityManager->flush();

        return $player;
    }
}