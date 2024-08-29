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
    protected $partnerPrivateKeyPath;
    protected $publicKeyPath;

    public function __construct(string $mode, string $partnerCode, string $publicKeyPath, string $partnerPrivateKeyPath)
    {
        $this->baseUrl = $mode === 'prod' 
            ? 'https://api-bdvn.postpay.vn/' 
            : 'https://api-bdvn-dev.postpay.vn/';
        
        $this->partnerCode = $partnerCode;
        $this->partnerPrivateKeyPath = $partnerPrivateKeyPath;
        $this->publicKeyPath = $publicKeyPath;
        
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => 5.0,
            'verify' => $this->publicKeyPath,
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
        $signature = $this->generateSignature($data);

        return [
            'partnerCode' => $this->partnerCode,
            'signature' => $signature,
        ] + $data;
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
        $requestId = $data['requestId'];
        unset($data['requestId']);
        $rawData = $this->partnerCode . '|' . $requestId . '|' . $this->convertDataToString($data);
        
        $privateKey = file_get_contents($this->partnerPrivateKeyPath);
        $privateKeyResource = openssl_pkey_get_private($privateKey);
        
        if (!$privateKeyResource) {
            throw new \Exception('Invalid private key');
        }

        $signature = '';
        if (!openssl_sign($rawData, $signature, $privateKeyResource, OPENSSL_ALGO_SHA256)) {
            throw new \Exception('Failed to generate signature');
        }

        return base64_encode($signature);
    }

    public function verifySignature(array $response): bool
    {
        $rawData = $response['code'] . '|' . $response['message'] . '|' . $this->convertDataToString($response['body']);
        
        $publicKey = file_get_contents($this->publicKeyPath);
        $publicKeyResource = openssl_pkey_get_public($publicKey);
        
        if (!$publicKeyResource) {
            throw new \Exception('Invalid public key');
        }

        $signature = base64_decode($response['signature']);
        $verifyResult = openssl_verify($rawData, $signature, $publicKeyResource, OPENSSL_ALGO_SHA256);
        
        return $verifyResult === 1;
    }

    private function convertDataToString(array $data): string
    {
        return implode('|',array_values($data));
    }
}
