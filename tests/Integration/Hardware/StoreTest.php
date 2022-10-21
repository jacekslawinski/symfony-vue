<?php

namespace Tests\Integration\Hardware;

use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;
use Faker\Factory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tests\AbstractTestCase;
use Tests\Data\ApiUrls;

/**
 *
 * @group api
 * @group HardwareController
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
                    'serialNumber' => $fakerData->text(100),
                    'productionMonth' => $fakerData->date('Y-m'),
                ]
            ],
            [
                [
                    'name' => $fakerData->lexify(\str_repeat('?', 101)),
                    'serialNumber' => $fakerData->text(100),
                    'productionMonth' => $fakerData->date('Y-m'),
                ]
            ],
            [
                [
                    'name' => $fakerData->text(100),
                    'productionMonth' => $fakerData->date('Y-m'),
                ]
            ],
            [
                [
                    'name' => $fakerData->text(100),
                    'serialNumber' => $fakerData->lexify(\str_repeat('?', 101)),
                    'productionMonth' => $fakerData->date('Y-m'),
                ]
            ],
            [
                [
                    'name' => $fakerData->text(100),
                    'serialNumber' => $fakerData->text(100),
                    'productionMonth' => $fakerData->date('Y'),
                ]
            ],
            [
                [
                    'name' => $fakerData->text(100),
                    'serialNumber' => $fakerData->text(100),
                    'productionMonth' => $fakerData->date('Y-m-d'),
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
        $name = $this->faker->text(100);
        $serialNumber = $this->faker->text(100);
        $productionMonth = $this->faker->date('Y-m');
        $this->postRequest(
            ApiUrls::API_HARDWARE_ROUTE,
            [
                'name' => $name,
                'serialNumber' => $serialNumber,
                'productionMonth' => $productionMonth
            ]
        );
        $this->assertResponseIsSuccessful();
        $response = json_decode($this->getResponse()->getContent(), true);
        $this->assertArraySubset([
            'message' => 'success',
            'result' =>
                [
                    'name' => $name,
                    'serialNumber' => $serialNumber
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
        $this->postRequest(ApiUrls::API_HARDWARE_ROUTE, $data);
        $this->assertResponseStatusCodeSame(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }
}
