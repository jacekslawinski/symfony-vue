<?php

namespace Tests\Integration\System;

use Symfony\Component\HttpFoundation\JsonResponse;
use Tests\AbstractTestCase;
use Tests\Data\ApiUrls;
use Tests\Traits\CreateSystemTrait;

/**
 *
 * @group api
 * @group SystemController
 */
class DeleteTest extends AbstractTestCase
{
    use CreateSystemTrait;

    /**
     *
     * @test
     */
    public function deleteSuccess(): void
    {
        $system = $this->createSystem();
        $this->deleteRequest(ApiUrls::API_SYSTEM_ROUTE . '/' . $system->getId());
        $this->assertResponseStatusCodeSame(JsonResponse::HTTP_NO_CONTENT);
    }

    /**
     *
     * @test
     */
    public function deleteFailureNoSystem(): void
    {
        $system = $this->createSystem();
        $this->deleteRequest(ApiUrls::API_SYSTEM_ROUTE . '/' . ($system->getId() + 1));
        $this->assertResponseStatusCodeSame(JsonResponse::HTTP_BAD_REQUEST);
    }
}
