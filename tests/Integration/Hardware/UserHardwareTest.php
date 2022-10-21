<?php

namespace Tests\Integration\Hardware;

use Symfony\Component\HttpFoundation\JsonResponse;
use Tests\AbstractTestCase;
use Tests\Data\ApiUrls;
use Tests\Traits\CreateHardwareTrait;
use Tests\Traits\CreateUserHardwareTrait;
use Tests\Traits\CreateUserTrait;

/**
 *
 * @group api
 * @group UserHardwareController
 */
class UserHardwareTest extends AbstractTestCase
{
    use CreateHardwareTrait;
    use CreateUserTrait;
    use CreateUserHardwareTrait;

    /**
     *
     * @test
     */
    public function addUserHardwareSuccess(): void
    {
        $hardware = $this->createHardware();
        $user = $this->createUser();
        $this->postRequest(ApiUrls::API_HARDWARE_ROUTE . '/' . $hardware->getId() . '/user/' . $user->getId());
        $this->assertResponseIsSuccessful();
    }

    /**
     *
     * @test
     */
    public function addUserHardwareFailureBadHardware(): void
    {
        $hardware = $this->createHardware();
        $user = $this->createUser();
        $this->postRequest(ApiUrls::API_HARDWARE_ROUTE . '/' . ($hardware->getId() + 1) . '/user/' . $user->getId());
        $this->assertResponseStatusCodeSame(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     *
     * @test
     */
    public function addUserHardwareFailureBadUser(): void
    {
        $hardware = $this->createHardware();
        $user = $this->createUser();
        $this->postRequest(ApiUrls::API_HARDWARE_ROUTE . '/' . $hardware->getId() . '/user/' . ($user->getId() + 1));
        $this->assertResponseStatusCodeSame(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     *
     * @test
     */
    public function deleteUserHardwareSuccess(): void
    {
        $hardware = $this->createHardware();
        $user = $this->createUser();
        $this->createUserHardware($user, $hardware);
        $this->deleteRequest(ApiUrls::API_HARDWARE_ROUTE . '/' . $hardware->getId() . '/user');
        $this->assertResponseIsSuccessful();
    }

    /**
     *
     * @test
     */
    public function deleteUserHardwareFailure(): void
    {
        $hardware = $this->createHardware();
        $user = $this->createUser();
        $this->createUserHardware($user, $hardware);
        $this->deleteRequest(ApiUrls::API_HARDWARE_ROUTE . '/' . ($hardware->getId() + 1) . '/user');
        $this->assertResponseStatusCodeSame(JsonResponse::HTTP_BAD_REQUEST);
    }
}
