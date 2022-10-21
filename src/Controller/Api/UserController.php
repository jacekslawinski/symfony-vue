<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\User;
use App\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class UserController extends AbstractController
{
    private const SERIALIZER_GROUP = 'user';

    /**
     *
     * @param UserService $userService
     */
    public function __construct(
        private readonly UserService $userService
    ) {
    }

    /**
     *
     * @return JsonResponse
     */
    #[Route('/user', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $response = $this->userService->getUserList();
        return $this->json($response->getResponseData(), $response->getResponseStatus(), [], [
            'groups' => self::SERIALIZER_GROUP
        ]);
    }

    /**
     *
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/user', methods: ['POST'])]
    public function store(Request $request): JsonResponse
    {
        $response = $this->userService->createUser($request);
        return $this->json($response->getResponseData(), $response->getResponseStatus(), [], [
            'groups' => self::SERIALIZER_GROUP
        ]);
    }

    /**
     *
     * @param User $user
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/user/{user}', methods: ['PUT'])]
    public function update(Request $request, User $user = null): JsonResponse
    {
        if (null === $user) {
            return $this->json([], JsonResponse::HTTP_BAD_REQUEST);
        }
        $response = $this->userService->updateUser($user, $request);
        return $this->json($response->getResponseData(), $response->getResponseStatus(), [], [
            'groups' => self::SERIALIZER_GROUP
        ]);
    }

    /**
     *
     * @param User $user
     * @return JsonResponse
     */
    #[Route('/user/{user}', methods: ['DELETE'])]
    public function destroy(User $user = null): JsonResponse
    {
        if (null === $user) {
            return $this->json([], JsonResponse::HTTP_BAD_REQUEST);
        }
        $response = $this->userService->deleteUser($user);
        return $this->json($response->getResponseData(), $response->getResponseStatus());
    }
}
