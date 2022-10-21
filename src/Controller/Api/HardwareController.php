<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\Hardware;
use App\Entity\User;
use App\Services\HardwareService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class HardwareController extends AbstractController
{
    private const SERIALIZER_GROUP = 'hardware';

    /**
     *
     * @param HardwareService $hardwareService
     */
    public function __construct(
        private readonly HardwareService $hardwareService
    ) {
    }

    #[Route('/hardware', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $response = $this->hardwareService->getHardwareList();
        return $this->json($response->getResponseData(), $response->getResponseStatus(), [], [
            'groups' => self::SERIALIZER_GROUP
        ]);
    }

    /**
     *
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/hardware', methods: ['POST'])]
    public function store(Request $request): JsonResponse
    {
        $response = $this->hardwareService->createHardware($request);
        return $this->json($response->getResponseData(), $response->getResponseStatus(), [], [
            'groups' => self::SERIALIZER_GROUP
        ]);
    }

    /**
     *
     * @param Hardware $hardware
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/hardware/{hardware}', methods: ['PUT'])]
    public function update(Request $request, Hardware $hardware = null): JsonResponse
    {
        if (null === $hardware) {
            return $this->json([], JsonResponse::HTTP_BAD_REQUEST);
        }
        $response = $this->hardwareService->updateHardware($hardware, $request);
        return $this->json($response->getResponseData(), $response->getResponseStatus(), [], [
            'groups' => self::SERIALIZER_GROUP
        ]);
    }

    /**
     *
     * @param Hardware $hardware
     * @return JsonResponse
     */
    #[Route('/hardware/{hardware}', methods: ['DELETE'])]
    public function destroy(Hardware $hardware = null): JsonResponse
    {
        if (null === $hardware) {
            return $this->json([], JsonResponse::HTTP_BAD_REQUEST);
        }
        $response = $this->hardwareService->deleteHardware($hardware);
        return $this->json($response->getResponseData(), $response->getResponseStatus());
    }

    /**
     *
     * @param Request $request
     * @param Hardware $hardware, default: null
     * @return JsonResponse
     */
    #[Route('/hardware/{hardware}/user', methods: ['DELETE'])]
    public function deleteUserHardware(Request $request, Hardware $hardware = null): JsonResponse
    {
        if (null === $hardware) {
            return $this->json([], JsonResponse::HTTP_BAD_REQUEST);
        }
        $response = $this->hardwareService->deleteUserHardware($hardware);
        return $this->json($response->getResponseData(), $response->getResponseStatus());
    }

    /**
     *
     * @param Hardware $hardware, default: null
     * @param User $user, default: null
     * @return JsonResponse
     */
    #[Route('/hardware/{hardware}/user/{user}', methods: ['POST'])]
    public function addUserHardware(Hardware $hardware = null, User $user = null): JsonResponse
    {
        if (null === $hardware || null === $user) {
            return $this->json([], JsonResponse::HTTP_BAD_REQUEST);
        }
        $response = $this->hardwareService->addUserHardware($hardware, $user);
        return $this->json($response->getResponseData(), $response->getResponseStatus());
    }
}
