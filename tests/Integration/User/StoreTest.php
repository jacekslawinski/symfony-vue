<?php

namespace Tests\Integration\User;

use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;
use Faker\Factory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tests\AbstractTestCase;
use Tests\Data\ApiUrls;

/**
 *
 * @group api
 * @group UserController
 */
class StoreTest extends AbstractTestCase
{
    use ArraySubsetAsserts;

    /**
     *
     * @return array
     */
    public function storeData(): array
    {
        $fakerData = Factory::create('pl');
        return [
            [
                [
                    'firstname' => $fakerData->firstName(),
                    'lastname' => $fakerData->lastName(),
                ]
            ],
            [
                [
                    'firstname' => $fakerData->lexify(\str_repeat('?', 51)),
                    'lastname' => $fakerData->lastName(),
                    'email' => $fakerData->email(),
                ]
            ],
            [
                [
                    'firstname' => $fakerData->firstName(),
                    'email' => $fakerData->email(),
                ]
            ],
            [
                [
                    'firstname' => $fakerData->firstName(),
                    'lastname' => $fakerData->lexify(\str_repeat('?', 51)),
                    'email' => $fakerData->email(),
                ]
            ],
            [
                [
                    'firstname' => $fakerData->firstName(),
                    'lastname' => $fakerData->lastName(),
                    'email' => $fakerData->word(),
                ]
            ]
        ];
    }

    /**
     *
     * @test
     */
    public function storeSuccess(): void
    {
        $firstname = $this->faker->firstName();
        $lastname = $this->faker->lastName();
        $email = $this->faker->email();
        $this->postRequest(
            ApiUrls::API_USER_ROUTE,
            [
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $email
            ]
        );
        $this->assertResponseIsSuccessful();
        $response = json_decode($this->getResponse()->getContent(), true);
        $this->assertArraySubset([
            'message' => 'success',
            'result' =>
                [
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'email' => $email
                ]
            ], $response);
    }

    /**
     *
     * @test
     * @dataProvider storeData
     */
    public function storeFailureBadData(array $data): void
    {
        $this->postRequest(ApiUrls::API_USER_ROUTE, $data);
        $this->assertResponseStatusCodeSame(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }
}
