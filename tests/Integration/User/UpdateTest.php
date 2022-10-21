<?php

namespace Tests\Integration\User;

use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;
use Faker\Factory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tests\AbstractTestCase;
use Tests\Data\ApiUrls;
use Tests\Traits\CreateUserTrait;

/**
 *
 * @group api
 * @group UserController
 */
class UpdateTest extends AbstractTestCase
{
    use ArraySubsetAsserts;
    use CreateUserTrait;

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
    public function updateSuccess(): void
    {
        $user = $this->createUser();
        $firstname = $this->faker->firstName();
        $lastname = $this->faker->lastName();
        $email = $this->faker->email();
        $this->putRequest(
            ApiUrls::API_USER_ROUTE . '/' . $user->getId(),
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
     */
    public function updateFailureUserNotFound(): void
    {
        $user = $this->createUser();
        $firstname = $this->faker->firstName();
        $lastname = $this->faker->lastName();
        $email = $this->faker->email();
        $this->putRequest(
            ApiUrls::API_USER_ROUTE . '/' . ($user->getId() + 1),
            [
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $email
            ]
        );
        $this->assertResponseStatusCodeSame(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     *
     * @test
     * @dataProvider storeData
     */
    public function updateFailureBadData(array $data): void
    {
        $user = $this->createUser();
        $this->putRequest(ApiUrls::API_USER_ROUTE . '/' . $user->getId(), $data);
        $this->assertResponseStatusCodeSame(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }
}
