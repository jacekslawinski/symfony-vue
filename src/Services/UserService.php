<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Request\UserRequest;
use App\Responses\AbstractRespondJson;
use App\Responses\RespondNoContentJson;
use App\Responses\RespondServerErrorJson;
use App\Responses\RespondSuccessJson;
use Doctrine\ORM\Query\QueryException;
use Symfony\Component\HttpFoundation\Request;

final class UserService
{
    /**
     *
     * @param UserRepository $userRepository
     * @param UserRequest $userRequest
     */
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserRequest $userRequest
    ) {
    }

    /**
     *
     * @return AbstractRespondJson
     */
    public function getUserList(): AbstractRespondJson
    {
        try {
            $response = new RespondSuccessJson('success', $this->userRepository->findAll());
        } catch (QueryException) {
            $response = new RespondServerErrorJson('Błąd pobierania listy użytkowników');
        }
        return $response;
    }

    /**
     *
     * @param Request $request
     * @return AbstractRespondJson
     */
    public function createUser(Request $request): AbstractRespondJson
    {
        $user = $this->userRequest->getUserFromRequestedData($request);
        try {
            $this->userRepository->save($user);
            $response = new RespondSuccessJson('success', $user);
        } catch (QueryException) {
            $response = new RespondServerErrorJson('Błąd dodawania użytkownika');
        }
        return $response;
    }

    /**
     *
     * @param User $user
     * @param Request $request
     * @return AbstractRespondJson
     */
    public function updateUser(User $user, Request $request): AbstractRespondJson
    {
        $user = $this->userRequest->getUserFromRequestedData($request, $user);
        try {
            $this->userRepository->save($user);
            $response = new RespondSuccessJson('success', $user);
        } catch (QueryException) {
            $response = new RespondServerErrorJson('Błąd aktualizacji użytkownika');
        }
        return $response;
    }

    /**
     *
     * @param User $user
     * @return AbstractRespondJson
     */
    public function deleteUser(User $user): AbstractRespondJson
    {
        try {
            $this->userRepository->remove($user);
            $response = new RespondNoContentJson();
        } catch (QueryException) {
            $response = new RespondServerErrorJson('Błąd usuwania użytkownika');
        }
        return $response;
    }
}
