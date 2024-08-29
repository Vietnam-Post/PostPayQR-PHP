<?php

namespace Postpay;

use GuzzleHttp\Client;
use Postpay\Responses\{
    CreateAccountResponse,
    CloseAccountResponse,
    DetailAccountResponse,
    SearchTransactionResponse,
    CallbackResponse
};

class PostpayClient
{
    protected $client;
    protected $baseUrl;
    protected $keyPath;
    protected $partnerCode;

    public function __construct(string $mode, string $apiKeyPath, string $partnerCode)
    {
        $this->baseUrl = $mode === 'prod' 
            ? 'https://api-bdvn.postpay.vn/' 
            : 'https://api-bdvn-dev.postpay.vn/';
        
        $this->keyPath = $apiKeyPath;
        $this->partnerCode = $partnerCode;
        
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => 5.0,
        ]);
    }

    public function createAccount(array $data): CreateAccountResponse
    {
        $url = 'cob-partner/account/v1/create';
        $payload = $this->preparePayload($data);

        $response = $this->client->post($url, [
            'headers' => $this->prepareHeaders($payload),
            'json' => $payload,
        ]);

        return new CreateAccountResponse($response);
    }

    public function closeAccount(string $accountNumber): CloseAccountResponse
    {
        $url = 'cob-partner/account/v1/close';
        $payload = $this->preparePayload(['accNo' => $accountNumber]);

        $response = $this->client->post($url, [
            'headers' => $this->prepareHeaders($payload),
            'json' => $payload,
        ]);

        return new CloseAccountResponse($response);
    }

    public function detailAccount(string $accountNumber): DetailAccountResponse
    {
        $url = 'cob-partner/account/v1/detail';
        $payload = $this->preparePayload(['accNo' => $accountNumber]);

        $response = $this->client->post($url, [
            'headers' => $this->prepareHeaders($payload),
            'json' => $payload,
        ]);

        return new DetailAccountResponse($response);
    }

    public function searchTransaction(array $data): SearchTransactionResponse
    {
        $url = 'cob-partner/account/v1/search-trans';
        $payload = $this->preparePayload($data);

        $response = $this->client->post($url, [
            'headers' => $this->prepareHeaders($payload),
            'json' => $payload,
        ]);

        return new SearchTransactionResponse($response);
    }

    public function handleCallback(array $data): CallbackResponse
    {
        $url = 'cob-partner/account/v1/callback';
        $payload = $this->preparePayload($data);

        $response = $this->client->post($url, [
            'headers' => $this->prepareHeaders($payload),
            'json' => $payload,
        ]);

        return new CallbackResponse($response);
    }

    private function preparePayload(array $data): array
    {
        return [
            'partnerCode' => $this->partnerCode,
            'requestId' => uniqid(),
            'data' => $data,
        ];
    }

    private function prepareHeaders(array $payload): array
    {
        $certificate = file_get_contents($this->keyPath);
        $signature = $this->generateSignature($payload, $certificate);

        return [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $signature,
        ];
    }

    private function generateSignature(array $data, string $certificate): string
    {
        openssl_sign(json_encode($data), $signature, $certificate, OPENSSL_ALGO_SHA256);
        return base64_encode($signature);
    }
}
