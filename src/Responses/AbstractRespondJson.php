<?php

declare(strict_types=1);

namespace App\Responses;

abstract class AbstractRespondJson
{
    /**
     *
     * @var mixed $result
     */
    protected $result;

    /**
     *
     * @var string $message
     */
    protected string $message;

    /**
     *
     * @return int
     */
    abstract public function getResponseStatus(): int;

    /**
     *
     * @return array
     */
    public function getResponseData(): array
    {
        return [
            'result' => $this->result,
            'message' => $this->message
        ];
    }
}
