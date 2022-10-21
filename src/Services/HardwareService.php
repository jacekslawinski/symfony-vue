<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\Hardware;
use App\Entity\User;
use App\Entity\UserHardware;
use App\Repository\HardwareRepository;
use App\Repository\UserHardwareRepository;
use App\Request\HardwareRequest;
use App\Responses\AbstractRespondJson;
use App\Responses\RespondNoContentJson;
use App\Responses\RespondServerErrorJson;
use App\Responses\RespondSuccessJson;
use Doctrine\ORM\Query\QueryException;
use Symfony\Component\HttpFoundation\Request;

final class HardwareService
{
    /**
     *
     * @param HardwareRepository $hardwareRepository
     * @param UserHardwareRepository $userHardwareRepository
     * @param HardwareRequest $hardwareRequest
     */
    public function __construct(
        private readonly HardwareRepository $hardwareRepository,
        private readonly UserHardwareRepository $userHardwareRepository,
        private readonly HardwareRequest $hardwareRequest
    ) {
    }

    /**
     *
     * @return AbstractRespondJson
     */
    public function getHardwareList(): AbstractRespondJson
    {
        try {
            $response = new RespondSuccessJson('success', $this->hardwareRepository->findAll());
        } catch (QueryException) {
            $response = new RespondServerErrorJson('Błąd pobierania listy sprzętu');
        }
        return $response;
    }

    /**
     *
     * @param Request $request
     * @return AbstractRespondJson
     */
    public function createHardware(Request $request): AbstractRespondJson
    {
        $hardware = $this->hardwareRequest->getHardwareFromRequestedData($request);
        try {
            $this->hardwareRepository->save($hardware);
            $response = new RespondSuccessJson('success', $hardware);
        } catch (QueryException) {
            $response = new RespondServerErrorJson('Błąd dodawania sprzętu');
        }
        return $response;
    }

    /**
     *
     * @param Hardware $hardware
     * @param Request $request
     * @return AbstractRespondJson
     */
    public function updateHardware(Hardware $hardware, Request $request): AbstractRespondJson
    {
        $hardware = $this->hardwareRequest->getHardwareFromRequestedData($request, $hardware);
        try {
            $this->hardwareRepository->save($hardware);
            $response = new RespondSuccessJson('success', $hardware);
        } catch (QueryException) {
            $response = new RespondServerErrorJson('Błąd aktualizacji sprzętu');
        }
        return $response;
    }

    /**
     *
     * @param Hardware $hardware
     * @return AbstractRespondJson
     */
    public function deleteHardware(Hardware $hardware): AbstractRespondJson
    {
        try {
            $this->hardwareRepository->remove($hardware);
            $response = new RespondNoContentJson();
        } catch (QueryException) {
            $response = new RespondServerErrorJson('Błąd usuwania sprzętu');
        }
        return $response;
    }

    /**
     *
     * @param Hardware $hardware
     * @return AbstractRespondJson
     */
    public function deleteUserHardware(Hardware $hardware): AbstractRespondJson
    {
        try {
            $this->userHardwareRepository->removeBy($hardware);
            $response = new RespondNoContentJson();
        } catch (QueryException $e) {
            $response = new RespondServerErrorJson('Błąd usuwania położenia sprzętu');
        }
        return $response;
    }

    /**
     *
     * @param Hardware $hardware
     * @param User $user
     * @return AbstractRespondJson
     */
    public function addUserHardware(Hardware $hardware, User $user): AbstractRespondJson
    {
        try {
            $userHardware = new UserHardware();
            $userHardware->setHardware($hardware)
                ->setUser($user);
            $this->userHardwareRepository->save($userHardware);
            $response = new RespondSuccessJson();
        } catch (QueryException) {
            $response = new RespondServerErrorJson('Błąd dodawania położenia sprzętu');
        }
        return $response;
    }
}
