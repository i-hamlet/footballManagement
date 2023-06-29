<?php

declare(strict_types=1);

namespace App\Tests\Validator;

use App\Exception\InputValidationException;
use App\Repository\PlayerRepository;
use App\Repository\TeamRepository;
use App\Validator\TransferDataValidator;
use Generator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class TransferDataValidatorTest extends TestCase
{
    private readonly PlayerRepository|MockObject $playerRepositoryMock;
    private readonly TeamRepository|MockObject $teamRepositoryMock;

    public function setUp(): void
    {
        $this->playerRepositoryMock = $this->getMockBuilder(PlayerRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
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
        $validator = new TransferDataValidator($this->playerRepositoryMock, $this->teamRepositoryMock);

        //assert
        if (str_contains($this->getDataSetAsString(), 'invalidConstraint')) {
            self::expectException(InputValidationException::class);
        }
        if (str_contains($this->getDataSetAsString(), 'participantsNotExist')) {
            $this->teamRepositoryMock->expects(self::exactly(2))
                ->method('find')
                ->willReturn([]);
            $this->teamRepositoryMock->expects(self::exactly(2))
                ->method('find')
                ->willReturn([]);
            self::expectException(InputValidationException::class);
            $this->playerRepositoryMock->expects(self::once())
                ->method('find')
                ->with($data['playerId'])
                ->willReturn(['id' => $data['playerId']]);
        }
        if (str_contains($this->getDataSetAsString(), 'sameSellerAndBuyer')) {
            self::expectException(InputValidationException::class);
        }
        if (str_contains($this->getDataSetAsString(), 'playerDoesNotBelongToSeller')) {
            $this->playerRepositoryMock->expects(self::once())
                ->method('findOneBy')
                ->with(['id' => $data['playerId'], 'team' => $data['sellerId']])
                ->willReturn([]);
            self::expectException(InputValidationException::class);
        }

        //when
        $validator->validate($data);
    }

    public function validatorDataProvider(): Generator
    {
        yield 'invalidConstraint' => [['sellerId' => 1, 'buyerId' => 1]];
        yield 'participantsNotExist' => [['sellerId' => 1, 'buyerId' => 2, 'playerId' => 11, 'price' => 111.00]];
        yield 'sameSellerAndBuyer' => [['sellerId' => 1, 'buyerId' => 1, 'playerId' => 11, 'price' => 111.00]];
        yield 'playerDoesNotBelongToSeller' => [['sellerId' => 1, 'buyerId' => 2, 'playerId' => 11, 'price' => 111.00]];
    }
}