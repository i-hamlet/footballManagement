<?php

declare(strict_types=1);

namespace App\Validator;

use App\Exception\InputValidationException;
use App\Repository\PlayerRepository;
use App\Repository\TeamRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validation;

readonly class TransferDataValidator
{
    private Assert\Collection $constraints;
    private PlayerRepository $playerRepository;
    private TeamRepository $teamRepository;

    public function __construct(PlayerRepository $playerRepository, TeamRepository $teamRepository)
    {
        $this->playerRepository = $playerRepository;
        $this->teamRepository = $teamRepository;
        $this->constraints = new Assert\Collection([
            'sellerId' => new Assert\Required([
                new Assert\Type('integer'),
                new Assert\Positive(),
            ]),
            'buyerId' => new Assert\Required([
                new Assert\Type('integer'),
                new Assert\Positive(),
            ]),
            'playerId' => new Assert\Required([
                new Assert\Type('integer'),
                new Assert\Positive(),
            ]),
            'price' => new Assert\Required([
                new Assert\Type('float'),
                new Assert\Positive(),
            ]),
        ]);
    }

    /**
     * @throws InputValidationException
     */
    public function validate(array $transferData): void
    {
        $validator = Validation::createValidator();
        if (!empty($transferData['price'])) {
            $transferData['price'] = (float)$transferData['price'];
        }
        $errors = $validator->validate($transferData, $this->constraints);

        $this->makeSureParticipantsExist($transferData, $errors);
        $this->makeSureSellerAndBuyerDifferent($transferData, $errors);
        $this->makeSurePlayerBelongsToSeller($transferData, $errors);

        if ($errors->count() > 0) {
            throw new InputValidationException($errors);
        }
    }

    private function makeSureParticipantsExist(array $transferData, ConstraintViolationList $errors): void
    {
        if (!empty($transferData['sellerId'])) {
            $seller = $this->teamRepository->find($transferData['sellerId']);
            if (empty($seller)) {
                $errors->add(new ConstraintViolation("There is no seller with id {$transferData['sellerId']}", null, [], null, '[sellerId]', null));
            }
        }

        if (!empty($transferData['buyerId'])) {
            $seller = $this->teamRepository->find($transferData['buyerId']);
            if (empty($seller)) {
                $errors->add(new ConstraintViolation("There is no buyer with id {$transferData['buyerId']}", null, [], null, '[buyerId]', null));
            }
        }

        if (!empty($transferData['playerId'])) {
            $seller = $this->playerRepository->find($transferData['playerId']);
            if (empty($seller)) {
                $errors->add(new ConstraintViolation("There is no player with id {$transferData['playerId']}", null, [], null, '[playerId]', null));
            }
        }
    }

    private function makeSureSellerAndBuyerDifferent(array $transferData, ConstraintViolationList $errors): void
    {
        if (!empty($transferData['sellerId']) && !empty($transferData['buyerId']) && $transferData['sellerId'] === $transferData['buyerId']) {
            $errors->add(new ConstraintViolation('[sellerId] and [buyerId] should be different', null, [], null, '[sellerId, buyerId]', null));
        }
    }

    private function makeSurePlayerBelongsToSeller(array $transferData, ConstraintViolationList $errors): void
    {
        if (!empty($transferData['sellerId']) && !empty($transferData['playerId'])) {
            $teamPlayer = $this->playerRepository->findOneBy(['id' => $transferData['playerId'], 'team' => $transferData['sellerId']]);
            if (empty($teamPlayer)) {
                $errors->add(new ConstraintViolation('[playerId] does not belong to [sellerId]', null, [], null, '[sellerId, playerId]', null));
            }
        }
    }

}