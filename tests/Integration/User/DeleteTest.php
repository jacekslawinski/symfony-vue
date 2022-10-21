<?php

namespace Tests\Integration\User;

use Symfony\Component\HttpFoundation\JsonResponse;
use Tests\AbstractTestCase;
use Tests\Data\ApiUrls;
use Tests\Traits\CreateUserTrait;

/**
 *
 * @group api
 * @group UserController
 */
class DeleteTest extends AbstractTestCase
{
    use CreateUserTrait;

    /**
     *
     * @test
     */
    public function deleteSuccess(): void
    {
        $user = $this->createUser();
        $this->deleteRequest(ApiUrls::API_USER_ROUTE . '/' . $user->getId());
        $this->assertResponseStatusCodeSame(JsonResponse::HTTP_NO_CONTENT);
    }

    /**
     *
     * @test
     */
    public function deleteFailureNoUser(): void
    {
        $user = $this->createUser();
        $this->deleteRequest(ApiUrls::API_USER_ROUTE . '/' . ($user->getId() + 1));
        $this->assertResponseStatusCodeSame(JsonResponse::HTTP_BAD_REQUEST);
    }
}
