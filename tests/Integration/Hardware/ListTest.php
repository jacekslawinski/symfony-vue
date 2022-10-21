<?php

namespace Tests\Integration\Hardware;

use Tests\AbstractTestCase;
use Tests\Data\ApiUrls;
use Tests\Traits\CreateHardwareTrait;

/**
 *
 * @group api
 * @group HardwareController
 */
class ListTest extends AbstractTestCase
{
    use CreateHardwareTrait;

    /**
     *
     * @test
     */
    public function listSuccess(): void
    {
        $count = $this->faker->numberBetween(1, 100);
        $this->createSeveralHardwares($count);

        $this->getRequest(ApiUrls::API_HARDWARE_ROUTE);
        $response = json_decode($this->getResponse()->getContent(), true);
        $this->assertResponseIsSuccessful();
        $this->assertCount($count, $response['result']);
    }
}
