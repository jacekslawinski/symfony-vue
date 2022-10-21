<?php

namespace Tests\Integration\System;

use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;
use Symfony\Component\HttpFoundation\Response;
use Tests\AbstractTestCase;
use Tests\Data\ApiUrls;
use Tests\Traits\CreateSystemTrait;

/**
 *
 * @group api
 * @group SystemController
 */
class UpdateTest extends AbstractTestCase
{
    use ArraySubsetAsserts;
    use CreateSystemTrait;

    /**
     *
     * @test
     */
    public function updateSuccess(): void
    {
        $system = $this->createSystem();
        $name = $this->faker->text(100);
        $this->putRequest(
            ApiUrls::API_SYSTEM_ROUTE . '/' . $system->getId(),
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
    public function updateFailureNameTooLong(): void
    {
        $system = $this->createSystem();
        $this->putRequest(
            ApiUrls::API_SYSTEM_ROUTE . '/' . $system->getId(),
            [
                'name' => $this->faker->lexify(\str_repeat('?', 101))
            ]
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     *
     * @test
     */
    public function updateFailureNameEmpty(): void
    {
        $system = $this->createSystem();
        $this->putRequest(
            ApiUrls::API_SYSTEM_ROUTE . '/' . $system->getId(),
            [
                'name' => ''
            ]
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     *
     * @test
     */
    public function updateFailureSystemNotFound(): void
    {
        $system = $this->createSystem();
        $this->putRequest(
            ApiUrls::API_SYSTEM_ROUTE . '/' . ($system->getId() + 1),
            [
                'name' => $this->faker->text(100)
            ]
        );
        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }
}
