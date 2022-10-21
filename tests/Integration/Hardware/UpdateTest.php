<?php

namespace Tests\Integration\Hardware;

use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;
use Faker\Factory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tests\AbstractTestCase;
use Tests\Data\ApiUrls;
use Tests\Traits\CreateHardwareTrait;

/**
 *
 * @group api
 * @group HardwareController
 */
class UpdateTest extends AbstractTestCase
{
    use ArraySubsetAsserts;
    use CreateHardwareTrait;

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
    public function updateSuccess(): void
    {
        $hardware = $this->createHardware();
        $name = $this->faker->text(100);
        $serialNumber = $this->faker->text(100);
        $productionMonth = $this->faker->date('Y-m');
        $this->putRequest(
            ApiUrls::API_HARDWARE_ROUTE . '/' . $hardware->getId(),
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
                    'serialNumber' => $serialNumber,
                    'productionMonth' => $productionMonth
                ]
            ], $response);
    }

    /**
     *
     * @test
     */
    public function updateFailureHardwareNotFound(): void
    {
        $hardware = $this->createHardware();
        $name = $this->faker->text(100);
        $serialNumber = $this->faker->text(100);
        $productionMonth = $this->faker->date('Y-m');
        $this->putRequest(
            ApiUrls::API_HARDWARE_ROUTE . '/' . ($hardware->getId() + 1),
            [
                'name' => $name,
                'serialNumber' => $serialNumber,
                'productionMonth' => $productionMonth
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
        $hardware = $this->createHardware();
        $this->putRequest(ApiUrls::API_HARDWARE_ROUTE . '/' . $hardware->getId(), $data);
        $this->assertResponseStatusCodeSame(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }
}
