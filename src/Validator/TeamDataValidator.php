<?php

declare(strict_types=1);

namespace App\Validator;


use App\Exception\InputValidationException;
use App\Repository\TeamRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validation;

readonly class TeamDataValidator
{
    private Assert\Collection $constraints;
    private TeamRepository $teamRepository;

    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
        $this->constraints = new Assert\Collection([
            'name' => new Assert\Required([
                new Assert\Type('string'),
                new Assert\Length(null, 1),
            ]),
            'country' => new Assert\Required([
                new Assert\Type('string'),
                new Assert\Length(null, 1),
            ]),
            'balance' => new Assert\Required([
                new Assert\Type('float'),
                new Assert\Positive(),
            ]),
        ]);
    }

    /**
     * @throws InputValidationException
     */
    public function validate(array $teamData): void
    {
        $validator = Validation::createValidator();
        $errors = $validator->validate($teamData, $this->constraints);

        $this->checkIfRecordAlreadyExist($teamData, $errors);

        if ($errors->count() > 0) {
            throw new InputValidationException($errors);
        }
    }

    private function checkIfRecordAlreadyExist(array $teamData, ConstraintViolationList $errors): void
    {
        if (!empty($teamData['name']) && !empty($teamData['country'])) {
            $record = $this->teamRepository->findOneBy(['name' => $teamData['name'], 'country' => $teamData['country']]);
            if (!empty($record)) {
                $errors->add(new ConstraintViolation("Team already exist", null, [], null, '[name, country]', null));
            }
        }
    }

}