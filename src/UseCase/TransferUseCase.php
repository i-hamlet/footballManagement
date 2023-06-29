<?php

declare(strict_types=1);

namespace App\UseCase;

use App\DTO\TransferData;
use App\Entity\Transfer;
use App\Exception\UnexpectedException;
use App\Repository\PlayerRepository;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

readonly class TransferUseCase
{
    public function __construct(
        private TeamRepository $teamRepository,
        private PlayerRepository $playerRepository,
        private EntityManagerInterface $entityManager,
        private LoggerInterface $logger
    ){}

    /**
     * @throws UnexpectedException
     */
    public function execute(TransferData $transferData): void
    {
        $seller = $this->teamRepository->find($transferData->getSellerId());
        $buyer = $this->teamRepository->find($transferData->getBuyerId());
        $player = $this->playerRepository->find($transferData->getPlayerId());
        $transfer = new Transfer();

        $sellerBalance = $seller->getBalance() + $transferData->getPrice();
        $buyerBalance = $buyer->getBalance() - $transferData->getPrice();

        $seller->setBalance($sellerBalance);
        $buyer->setBalance($buyerBalance);
        $player->setTeam($buyer);
        $transfer->setSeller($seller)->setBuyer($buyer)->setPlayer($player)->setPrice($transferData->getPrice());

        try {
            $this->entityManager->beginTransaction();
            $this->entityManager->persist($seller);
            $this->entityManager->persist($buyer);
            $this->entityManager->persist($player);
            $this->entityManager->persist($transfer);
            $this->entityManager->flush();
            $this->entityManager->commit();
        } catch (\Throwable $e) {
            $this->entityManager->rollback();

            $this->logger->error('ERROR_TRANSFER_PLAYER', [
                's_message' => $e->getMessage(),
                's_transfer_data' => json_encode($transferData->toArray())
            ]);

            throw new UnexpectedException();
        }
    }
}