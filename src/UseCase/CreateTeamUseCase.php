<?php

declare(strict_types=1);

namespace App\UseCase;

use App\DTO\TeamData;
use App\Entity\Team;
use Doctrine\ORM\EntityManagerInterface;

readonly class CreateTeamUseCase
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function execute(TeamData $teamData): Team
    {
        $team = new Team();
        $team->setName($teamData->getName());
        $team->setCountry($teamData->getCountry());
        $team->setBalance($teamData->getBalance());

        $this->entityManager->persist($team);
        $this->entityManager->flush();

        return $team;
    }
}