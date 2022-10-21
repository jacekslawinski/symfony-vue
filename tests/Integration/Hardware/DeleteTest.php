<?php

namespace Tests\Integration\Hardware;

use Symfony\Component\HttpFoundation\JsonResponse;
use Tests\AbstractTestCase;
use Tests\Data\ApiUrls;
use Tests\Traits\CreateHardwareTrait;

/**
 *
 * @group api
 * @group HardwareController
 */
class DeleteTest extends AbstractTestCase
{
    use CreateHardwareTrait;

    /**
     *
     * @test
     */
    public function deleteSuccess(): void
    {
        $hardware = $this->createHardware();
        $this->deleteRequest(ApiUrls::API_HARDWARE_ROUTE . '/' . $hardware->getId());
        $this->assertResponseStatusCodeSame(JsonResponse::HTTP_NO_CONTENT);
    }

    /**
     *
     * @test
     */
    public function deleteFailureNoHardware(): void
    {
        $hardware = $this->createHardware();
        $this->deleteRequest(ApiUrls::API_HARDWARE_ROUTE . '/' . ($hardware->getId() + 1));
        $this->assertResponseStatusCodeSame(JsonResponse::HTTP_BAD_REQUEST);
    }
}
