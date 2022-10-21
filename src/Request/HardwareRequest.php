<?php

declare(strict_types=1);

namespace App\Request;

use App\Entity\Hardware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

final class HardwareRequest extends AbstractDataRequest
{
    private const FIELD_NAME = 'name';
    private const FIELD_SERIAL_NUMBER = 'serialNumber';
    private const FIELD_PRODUCTION_MONTH = 'productionMonth';
    private const FIELD_SYSTEM_ID = 'systemId';
    private const ALLOWED_FIELDS = [
        self::FIELD_NAME,
        self::FIELD_SERIAL_NUMBER,
        self::FIELD_PRODUCTION_MONTH,
        self::FIELD_SYSTEM_ID
    ];

    /**
     *
     * @param Request $request
     * @param Hardware|null $hardware, default: null
     * @return Hardware
     */
    public function getHardwareFromRequestedData(Request $request, ?Hardware $hardware = null): Hardware
    {
        $data = $this->getRequestedData($request);
        $this->validateRequestedData($data);
        return $this->fillHardware($data, $hardware);
    }

    /**
     *
     * @param array $data
     * @param Hardware|null $hardware, default: null
     * @return Hardware
     */
    public function fillHardware(array $data, ?Hardware $hardware = null): Hardware
    {
        if (null === $hardware) {
            $hardware = new Hardware();
        }
        if (isset($data[self::FIELD_NAME])) {
            $hardware->setName($data[self::FIELD_NAME]);
        }
        if (isset($data[self::FIELD_SERIAL_NUMBER])) {
            $hardware->setSerialNumber($data[self::FIELD_SERIAL_NUMBER]);
        }
        if (isset($data[self::FIELD_PRODUCTION_MONTH])) {
            $hardware->setProductionMonth($data[self::FIELD_PRODUCTION_MONTH]);
        }
        if (isset($data[self::FIELD_SYSTEM_ID])) {
            $hardware->setSystemId($data[self::FIELD_SYSTEM_ID]);
        }
        return $hardware;
    }

    /**
     *
     * @return array
     */
    public function getAllowedProperties(): array
    {
        return self::ALLOWED_FIELDS;
    }

    /**
     *
     * @return array
     */
    public function getAssertions(): array
    {
        return [
            self::FIELD_NAME =>
                [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Length(max: 100)
                ],
            self::FIELD_SERIAL_NUMBER =>
                [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Length(max: 100)
                ],
            self::FIELD_PRODUCTION_MONTH =>
                [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Length(exactly: 7)
                ],
            self::FIELD_SYSTEM_ID =>
                [
                    new Assert\Optional()
                ]
        ];
    }
}
