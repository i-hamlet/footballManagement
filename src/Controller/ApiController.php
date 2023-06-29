<?php

namespace App\Controller;

use App\DTO\PlayerData;
use App\DTO\TeamData;
use App\DTO\TransferData;
use App\Exception\InputValidationException;
use App\Exception\UnexpectedException;
use App\Repository\TeamRepository;
use App\UseCase\CreatePlayerUseCase;
use App\UseCase\CreateTeamUseCase;
use App\UseCase\TransferUseCase;
use App\Validator\PlayerDataValidator;
use App\Validator\TeamDataValidator;
use App\Validator\TransferDataValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('/api/teams', methods: ['POST'])]
    public function addTeam(Request $request, CreateTeamUseCase $useCase, TeamDataValidator $validator): JsonResponse
    {
        $payload = $request->toArray();
        $requestData = [
            'name' => $payload['name'] ?? '',
            'country' => $payload['country'] ?? '',
            'balance' => (float)$payload['balance'] ?? 0,
        ];
        try {
            $validator->validate($requestData);
        } catch (InputValidationException $e) {
            return new JsonResponse(['errors' => $e->toArray()], Response::HTTP_BAD_REQUEST);
        }

        $teamData = new TeamData(
            $requestData['name'],
            $requestData['country'],
            $requestData['balance'],
        );

        $team = $useCase->execute($teamData);

        return new JsonResponse(['id' => $team->getId()], Response::HTTP_CREATED);
    }

    #[Route('/api/teams', methods: ['GET'])]
    public function getTeams(Request $request, TeamRepository $teamRepository): JsonResponse
    {
        $page = (int)$request->query->get('page', 1);
        $perPage = (int)$request->query->get('per_page', 10);

        $records = $teamRepository->getTableData($page, $perPage);

        return new JsonResponse($records);
    }

    #[Route('/api/teams/{teamId}/players', methods: ['POST'])]
    public function addPlayer(int $teamId, Request $request, CreatePlayerUseCase $useCase, PlayerDataValidator $validator): JsonResponse
    {
        $payload = $request->toArray();
        $payload['teamId'] = $teamId;

        try {
            $validator->validate($payload);
        } catch (InputValidationException $e) {
            return new JsonResponse(['errors' => $e->toArray()], Response::HTTP_BAD_REQUEST);
        }

        $playerData = new PlayerData(
            $payload['firstName'],
            $payload['lastName'],
            $payload['teamId'],
        );

        $player = $useCase->execute($playerData);

        return new JsonResponse(['id' => $player->getId()], Response::HTTP_CREATED);
    }

    #[Route('/api/transfer', methods: ['PUT'])]
    public function transfer(Request $request, TransferUseCase $useCase, TransferDataValidator $validator): JsonResponse
    {
        $payload = $request->toArray();
        try {
            $validator->validate($payload);
        } catch (InputValidationException $e) {
            return new JsonResponse(['errors' => $e->toArray()], Response::HTTP_BAD_REQUEST);
        }
        $transferData = new TransferData(
            $payload['sellerId'],
            $payload['buyerId'],
            $payload['playerId'],
            $payload['price'],
        );

        try {
            $useCase->execute($transferData);
        } catch (UnexpectedException $e) {
            return new JsonResponse([
                'error' => true,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse(['success' => true], Response::HTTP_OK);
    }
}
