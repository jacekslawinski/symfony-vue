<?php

namespace Tests\Integration\System;

use Tests\AbstractTestCase;
use Tests\Data\ApiUrls;
use Tests\Traits\CreateSystemTrait;

/**
 *
 * @group api
 * @group SystemController
 */
class ListTest extends AbstractTestCase
{
    use CreateSystemTrait;

    /**
     *
     * @test
     */
    public function listSuccess(): void
    {
        $count = $this->faker->numberBetween(1, 100);
        $this->createSeveralSystems($count);

        $this->getRequest(ApiUrls::API_SYSTEM_ROUTE);
        $response = json_decode($this->getResponse()->getContent(), true);
        $this->assertResponseIsSuccessful();
        $this->assertCount($count, $response['result']);
    }
}
