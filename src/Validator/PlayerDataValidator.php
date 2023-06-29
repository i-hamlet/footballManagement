<?php

declare(strict_types=1);

namespace App\Validator;


use App\Exception\InputValidationException;
use App\Repository\TeamRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validation;

readonly class PlayerDataValidator
{
    private Assert\Collection $constraints;
    private TeamRepository    $teamRepository;

    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
        $this->constraints = new Assert\Collection([
            'firstName' => new Assert\Required([
                new Assert\Type('string'),
                new Assert\Length(null, 1),
            ]),
            'lastName' => new Assert\Required([
                new Assert\Type('string'),
                new Assert\Length(null, 1),
            ]),
            'teamId' => new Assert\Required([
                new Assert\Type('integer'),
                new Assert\Positive(),
            ]),
        ]);
    }

    /**
     * @throws InputValidationException
     */
    public function validate(array $playerData): void
    {
        $validator = Validation::createValidator();
        $errors = $validator->validate($playerData, $this->constraints);

        $this->makeSureTeamExist($playerData, $errors);

        if ($errors->count() > 0) {
            throw new InputValidationException($errors);
        }
    }

    private function makeSureTeamExist(array $playerData, ConstraintViolationList $errors): void
    {
        if (!empty($playerData['teamId'])) {
            $record = $this->teamRepository->find($playerData['teamId']);
            if (empty($record)) {
                $errors->add(new ConstraintViolation("Team with id {$playerData['teamId']} doesn't exist", null, [], null, '[teamId]', null));
            }
        }
    }

}