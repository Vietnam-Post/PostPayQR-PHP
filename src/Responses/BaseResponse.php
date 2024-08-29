<?php

namespace Postpay\Responses;

use Postpay\Config\ErrorCodes;

class BaseResponse
{
    protected $response;
    protected $errorCodes;

    public function __construct($response)
    {
        $this->response = json_decode($response->getBody()->getContents(), true);
        $this->errorCodes = ErrorCodes::getErrorMessages();
    }

    public function getData(): array
    {
        return $this->response['body'] ?? [];
    }

    public function getErrorCode(): ?string
    {
        return $this->response['code'] ?? null;
    }

    public function getErrorMessage(): ?string
    {
        $code = $this->getErrorCode();
        return $this->errorCodes[$code] ?? 'Unknown error';
    }

    public function isSuccess(): bool
    {
        return $this->getErrorCode() === null;
    }
}
