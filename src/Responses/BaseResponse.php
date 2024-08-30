<?php

namespace Postpay\Responses;

use Postpay\Config\ErrorCodes;
use Postpay\PostpayClient;

class BaseResponse
{
    protected $response;
    protected $errorCodes;
    protected $postpayClient;
    
    public function __construct($response)
    {
        $this->response = json_decode($response->getBody()->getContents(), true);
        $this->errorCodes = ErrorCodes::getErrorMessages();
        $this->postpayClient = new PostpayClient;

        $this->verifySignature();
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
        // Kiểm tra nếu có lỗi trong phản hồi
        if ($this->getErrorCode()) {
            return false;
        }

        // Kiểm tra chữ ký
        return $this->verifySignature();
    }

    private function getSignature(): ?string
    {
        return $this->response['signature'] ?? null;
    }

    private function verifySignature(): bool
    {
        $signature = $this->getSignature();

        if (!$signature) {
            throw new \Exception('Signature not found in response');
        }

        return $this->postpayClient->verifySignature($this->response);
    }
}
