<?php

declare(strict_types=1);

namespace App\Request;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

final class UserRequest extends AbstractDataRequest
{
    private const FIELD_EMAIL = 'email';
    private const FIELD_FIRSTNAME = 'firstname';
    private const FIELD_LASTNAME = 'lastname';
    private const ALLOWED_FIELDS = [
        self::FIELD_EMAIL,
        self::FIELD_FIRSTNAME,
        self::FIELD_LASTNAME
    ];

    /**
     *
     * @param Request $request
     * @param User|null $user, default: null
     * @return User
     */
    public function getUserFromRequestedData(Request $request, ?User $user = null): User
    {
        $data = $this->getRequestedData($request);
        $this->validateRequestedData($data);
        return $this->fillUser($data, $user);
    }

    /**
     *
     * @param array $data
     * @param User|null $user, default: null
     * @return User
     */
    public function fillUser(array $data, ?User $user = null): User
    {
        if (null === $user) {
            $user = new User();
        }
        if (isset($data[self::FIELD_EMAIL])) {
            $user->setEmail($data[self::FIELD_EMAIL]);
        }
        if (isset($data[self::FIELD_FIRSTNAME])) {
            $user->setFirstname($data[self::FIELD_FIRSTNAME]);
        }
        if (isset($data[self::FIELD_LASTNAME])) {
            $user->setLastname($data[self::FIELD_LASTNAME]);
        }
        return $user;
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
            self::FIELD_EMAIL =>
                [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Email(),
                    new Assert\Length(max: 255)
                ],
            self::FIELD_FIRSTNAME =>
                [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Length(max: 50)
                ],
            self::FIELD_LASTNAME =>
                [
                    new Assert\NotNull(),
                    new Assert\NotBlank(),
                    new Assert\Length(max: 50)
                ]
        ];
    }
}
