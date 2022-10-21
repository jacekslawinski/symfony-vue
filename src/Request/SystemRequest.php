<?php

declare(strict_types=1);

namespace App\Request;

use App\Entity\System;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

final class SystemRequest extends AbstractDataRequest
{
    private const FIELD_NAME = 'name';
    private const ALLOWED_FIELDS = [
        self::FIELD_NAME
    ];

    /**
     *
     * @param Request $request
     * @param System|null $system, default: null
     * @return System
     */
    public function getSystemFromRequestedData(Request $request, ?System $system = null): System
    {
        $data = $this->getRequestedData($request);
        $this->validateRequestedData($data);
        return $this->fillSystem($data, $system);
    }

    /**
     *
     * @param array $data
     * @param System|null $system, default: null
     * @return System
     */
    public function fillSystem(array $data, ?System $system = null): System
    {
        if (null === $system) {
            $system = new System();
        }
        if (isset($data[self::FIELD_NAME])) {
            $system->setName($data[self::FIELD_NAME]);
        }
        return $system;
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
            ]
        ];
    }
}
