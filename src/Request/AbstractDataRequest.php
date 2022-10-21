<?php

declare(strict_types=1);

namespace App\Request;

use App\Exception\ValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractDataRequest
{
    /**
     *
     * @var ValidatorInterface $validator
     */
    private ValidatorInterface $validator;

    public function __construct()
    {
        $this->validator = Validation::createValidator();
    }

    /**
     *
     * @return array
     */
    abstract public function getAllowedProperties(): array;

    /**
     *
     * @return array
     */
    abstract public function getAssertions(): array;

    /**
     *
     * @param Request $request
     * @return array
     */
    public function getRequestedData(Request $request): array
    {
        $data = $request->request->all();
        return array_filter(
            $data,
            fn ($key) => in_array($key, $this->getAllowedProperties()),
            ARRAY_FILTER_USE_KEY
        );
    }

    /**
     *
     * @param array $data
     * @return void
     * @throws ValidationException
     */
    public function validateRequestedData(array $data): void
    {
        $errors = $this->validator->validate(
            $data,
            new Assert\Collection($this->getAssertions())
        );
        if (count($errors)) {
            $messages = [];
            foreach ($errors as $violation) {
                $messages[$violation->getPropertyPath()][] = $violation->getMessage();
            }
            throw new ValidationException($messages);
        }
    }
}
