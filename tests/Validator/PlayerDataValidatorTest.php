<?php

declare(strict_types=1);

namespace App\Tests\Validator;

use App\Exception\InputValidationException;
use App\Repository\TeamRepository;
use App\Validator\PlayerDataValidator;
use Generator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class PlayerDataValidatorTest extends TestCase
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
        $validator = new PlayerDataValidator($this->teamRepositoryMock);
        $teamData = [
            'id' => 1,
            'name'=> 'Test Team',
            'country' => 'UA',
            'balance' => 300000.00,
        ];

        //assert
        if (str_contains($this->getDataSetAsString(), 'invalidConstraint')) {
            self::expectException(InputValidationException::class);
        }
        if (str_contains($this->getDataSetAsString(), 'invalidRepositoryValidation')) {
            $this->teamRepositoryMock->expects(self::once())
                ->method('find')
                ->with($data['teamId'])
                ->willReturn([]);
            self::expectException(InputValidationException::class);
        }
        if (str_contains($this->getDataSetAsString(), 'happyPath')) {
            $this->teamRepositoryMock->expects(self::once())
                ->method('find')
                ->with($data['teamId'])
                ->willReturn($teamData);
        }

        //when
        $validator->validate($data);
    }

    public function validatorDataProvider(): Generator
    {
        yield 'invalidConstraint' => [['firstName' => 'Foo', 'lastName' => 'Bar']];
        yield 'invalidRepositoryValidation' => [['teamId' => 99, 'firstName' => 'Foo', 'lastName' => 'Bar']];
        yield 'happyPath' => [['teamId' => 1, 'firstName' => 'Foo', 'lastName' => 'Bar']];
    }
}