<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\System;
use App\Repository\SystemRepository;
use App\Request\SystemRequest;
use App\Responses\AbstractRespondJson;
use App\Responses\RespondNoContentJson;
use App\Responses\RespondServerErrorJson;
use App\Responses\RespondSuccessJson;
use Doctrine\ORM\Query\QueryException;
use Symfony\Component\HttpFoundation\Request;

final class SystemService
{

    /**
     *
     * @param SystemRepository $systemRepository
     */
    public function __construct(
        private readonly SystemRepository $systemRepository,
        private readonly SystemRequest $systemRequest
    ) {
    }

    /**
     *
     * @return JsonResponse
     */
    public function getSystemList(): AbstractRespondJson
    {
        try {
            $response = new RespondSuccessJson('success', $this->systemRepository->findAll());
        } catch (QueryException) {
            $response = new RespondServerErrorJson('Błąd pobierania listy systemów');
        }
        return $response;
    }

    /**
     *
     * @param Request $request
     * @return AbstractRespondJson
     */
    public function createSystem(Request $request): AbstractRespondJson
    {
        $system = $this->systemRequest->getSystemFromRequestedData($request);
        try {
            $this->systemRepository->save($system);
            $response = new RespondSuccessJson('success', $system);
        } catch (QueryException) {
            $response = new RespondServerErrorJson('Błąd dodawania systemu');
        }
        return $response;
    }

    /**
     *
     * @param System $system
     * @param Request $request
     * @return AbstractRespondJson
     */
    public function updateSystem(System $system, Request $request): AbstractRespondJson
    {
        $system = $this->systemRequest->getSystemFromRequestedData($request, $system);
        try {
            $this->systemRepository->save($system);
            $response = new RespondSuccessJson('success', $system);
        } catch (QueryException) {
            $response = new RespondServerErrorJson('Błąd aktualizacji systemu');
        }
        return $response;
    }

    /**
     *
     * @param System $system
     * @return AbstractRespondJson
     */
    public function deleteSystem(System $system): AbstractRespondJson
    {
        try {
            $this->systemRepository->remove($system, true);
            $response = new RespondNoContentJson();
        } catch (QueryException) {
            $response = new RespondServerErrorJson('Błąd usuwania systemu');
        }
        return $response;
    }
}
