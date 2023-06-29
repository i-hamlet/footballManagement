<?php

declare(strict_types=1);

namespace App\Tests\Validator;

use App\Exception\InputValidationException;
use App\Repository\TeamRepository;
use App\Validator\TeamDataValidator;
use Generator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class TeamDataValidatorTest extends TestCase
{
    private readonly TeamRepository|MockObject $teamRepositoryMock;

    public function setUp(): void
    {
        $this->teamRepositoryMock = $this->getMockBuilder(TeamRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @dataProvider validatorDataProvider
     */
    public function testValidate(array $data)
    {
        //given
        $validator = new TeamDataValidator($this->teamRepositoryMock);

        //assert
        if (str_contains($this->getDataSetAsString(), 'invalidConstraint')) {
            self::expectException(InputValidationException::class);
        }
        if (str_contains($this->getDataSetAsString(), 'invalidRepositoryValidation')) {
            $this->teamRepositoryMock->expects(self::once())
                ->method('findOneBy')
                ->with(['name' => $data['name'], 'country' => $data['country']])
                ->willReturn(['id' => 99]);
            self::expectException(InputValidationException::class);
        }
        if (str_contains($this->getDataSetAsString(), 'happyPath')) {
            $this->teamRepositoryMock->expects(self::once())
                ->method('findOneBy')
                ->with(['name' => $data['name'], 'country' => $data['country']])
                ->willReturn([]);
        }

        //when
        $validator->validate($data);
    }

    public function validatorDataProvider(): Generator
    {
        yield 'invalidConstraint' => [['name' => 'Test Team', 'country' => 'UA']];
        yield 'invalidRepositoryValidation' => [['name' => 'Test Team', 'country' => 'UA', 'balance' => 300000.00]];
        yield 'happyPath' => [['name' => 'Test Team', 'country' => 'USA', 'balance' => 300000.00]];
    }
}