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
    protected $partnerCode;

    public function __construct(string $mode, string $apiKeyPath, string $partnerCode)
    {
        $this->baseUrl = $mode === 'prod' 
            ? 'https://api-bdvn.postpay.vn/' 
            : 'https://api-bdvn-dev.postpay.vn/';
        
        $this->partnerCode = $partnerCode;
        
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => 5.0,
            'verify' => $apiKeyPath,
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
        $requestId = $data['requestId'] ?? uniqid();
        unset($data['requestId']);
        
        // $rawData = $this->partnerCode . '|' . $requestId . '|' . $data;
        // $signature = md5($rawData);
        $signature = md5(uniqid());

        return [
            'partnerCode' => $this->partnerCode,
            'requestId' => $requestId,
            'signature' => $signature,
            'data'      => $data,
        ];
    }

    private function prepareHeaders(array $payload): array
    {
        $signature = $this->generateSignature($payload);

        return [
            'Content-Type' => 'application/json',
        ];
    }

    private function generateSignature(array $data): string
    {
        return '';
    }
}
