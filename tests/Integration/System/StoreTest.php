<?php

namespace Tests\Integration\System;

use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tests\AbstractTestCase;
use Tests\Data\ApiUrls;

/**
 *
 * @group api
 * @group SystemController
 */
class StoreTest extends AbstractTestCase
{
    use ArraySubsetAsserts;

    /**
     *
     * @test
     */
    public function storeSuccess(): void
    {
        $name = $this->faker->text(100);
        $this->postRequest(
            ApiUrls::API_SYSTEM_ROUTE,
            [
                'name' => $name
            ]
        );
        $this->assertResponseIsSuccessful();
        $response = json_decode($this->getResponse()->getContent(), true);
        $this->assertArraySubset([
            'message' => 'success',
            'result' =>
                [
                    'name' => $name
                ]
            ], $response);
    }

    /**
     *
     * @test
     */
    public function storeFailureNoName(): void
    {
        $this->postRequest(
            ApiUrls::API_SYSTEM_ROUTE,
            []
        );
        $this->assertResponseStatusCodeSame(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     *
     * @test
     */
    public function storeFailureNameTooLong(): void
    {
        $this->postRequest(
            ApiUrls::API_SYSTEM_ROUTE,
            [],
            [
                'name' => $this->faker->lexify(\str_repeat('?', 101))
            ]
        );
        $this->assertResponseStatusCodeSame(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }
}
