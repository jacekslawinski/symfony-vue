<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\System;
use App\Services\SystemService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class SystemController extends AbstractController
{
    private const SERIALIZER_GROUP = 'system';

    /**
     *
     * @param SystemService $systemService
     */
    public function __construct(
        private readonly SystemService $systemService
    ) {
    }

    /**
     *
     * @return JsonResponse
     */
    #[Route('/system', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $response = $this->systemService->getSystemList();
        return $this->json($response->getResponseData(), $response->getResponseStatus(), [], [
            'groups' => self::SERIALIZER_GROUP
        ]);
    }

    /**
     *
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/system', methods: ['POST'])]
    public function store(Request $request): JsonResponse
    {
        $response = $this->systemService->createSystem($request);
        return $this->json($response->getResponseData(), $response->getResponseStatus(), [], [
            'groups' => self::SERIALIZER_GROUP
        ]);
    }

    /**
     *
     * @param Request $request
     * @param System $system, default: null
     * @return JsonResponse
     */
    #[Route('/system/{system}', methods: ['PUT'])]
    public function update(Request $request, System $system = null): JsonResponse
    {
        if (null === $system) {
            return $this->json([], JsonResponse::HTTP_BAD_REQUEST);
        }
        $response = $this->systemService->updateSystem($system, $request);
        return $this->json($response->getResponseData(), $response->getResponseStatus(), [], [
            'groups' => self::SERIALIZER_GROUP
        ]);
    }

    /**
     *
     * @param System $system
     * @return JsonResponse
     */
    #[Route('/system/{system}', methods: ['DELETE'])]
    public function destroy(System $system = null): JsonResponse
    {
        if (null === $system) {
            return $this->json([], JsonResponse::HTTP_BAD_REQUEST);
        }
        $response = $this->systemService->deleteSystem($system);
        return $this->json($response->getResponseData(), $response->getResponseStatus());
    }
}
