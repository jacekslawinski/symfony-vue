<?php

namespace Tests\Integration\User;

use Tests\AbstractTestCase;
use Tests\Data\ApiUrls;
use Tests\Traits\CreateUserTrait;

/**
 *
 * @group api
 * @group UserController
 */
class ListTest extends AbstractTestCase
{
    use CreateUserTrait;

    /**
     *
     * @test
     */
    public function listSuccess(): void
    {
        $count = $this->faker->numberBetween(1, 100);
        $this->createSeveralUsers($count);

        $this->getRequest(ApiUrls::API_USER_ROUTE);
        $response = json_decode($this->getResponse()->getContent(), true);
        $this->assertResponseIsSuccessful();
        $this->assertCount($count, $response['result']);
    }
}
