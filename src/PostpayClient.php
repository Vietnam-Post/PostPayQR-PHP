<?php
/*****************************************************************************
 * @Author                : KienNguyen<kiennt@vnpost.vn>                     *
 * @CreatedDate           : 2024-08-30 16:49:32                              *
 * @LastEditors           : KienNguyen<kiennt@vnpost.vn>                     *
 * @LastEditDate          : 2024-09-10 10:18:23                              *
 * @FilePath              : PostpayClient.php                                *
 * @CopyRight             : VietNamPost (vietnampost.vn)                     *
 ****************************************************************************/

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

    public function __construct()
    {
        $mode = env('POSTPAY_MODE', env('postpay.mode', 'dev'));
        $this->baseUrl = $mode === 'prod'
            ? 'https://api-bdvn.postpay.vn/'
            : 'https://api-bdvn-dev.postpay.vn/';

        $this->partnerCode = env('POSTPAY_PARTNER_CODE', env('postpay.partner_code'));
        $this->publicKeyPath = env('POSTPAY_API_KEY_PATH', env('postpay.api_key_path'));
        $this->partnerPrivateKeyPath = env('POSTPAY_PARTNER_PRIVATE_KEY_PATH', env('postpay.partner_private_key_path'));

        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => 5.0,
            'verify' => false,
        ]);
    }
    
    /**
     * createAccount
     *
     * @param  mixed $data
     * @return CreateAccountResponse
     */
    public function createAccount(array $data): CreateAccountResponse
    {
        $url = 'cob-partner/account/v1/create';
        $payload = $this->preparePayload($data);

        $response = $this->client->post($url, [
            'headers'   => $this->prepareHeaders($payload),
            'json'      => $payload,
            'ssl_key'   => $this->publicKeyPath,
        ]);

        return new CreateAccountResponse($response);
    }
    
    /**
     * closeAccount
     *
     * @param  mixed $accountNumber
     * @return CloseAccountResponse
     */
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
    
    /**
     * detailAccount
     *
     * @param  mixed $accountNumber
     * @return DetailAccountResponse
     */
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
    
    /**
     * searchTransaction
     *
     * @param  mixed $data
     * @return SearchTransactionResponse
     */
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
    
    /**
     * handleCallback
     *
     * @param  mixed $data
     * @return CallbackResponse
     */
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
    
    /**
     * signatureData
     *
     * @param  mixed $data
     * @return void
     */
    private function signatureData($data) {
        return [
            $data['accNameSuffix'] ?? '',
            $data['accNoSuffix'] ?? '',
            $data['accType'] ?? '',
            $data['fixedAmount'] ?? '',
            $data['partnerAccNo'] ?? '',
        ];
    }
        
    /**
     * preparePayload
     *
     * @param  mixed $data
     * @return array
     */
    private function preparePayload(array $data): array
    {
        $signature = $this->generateSignature($this->signatureData($data), $data['requestId'] ?? '');
        return array_merge([
            'partnerCode' => $this->partnerCode,
            'signature' => $signature,
        ], $data);
    }
    
    /**
     * prepareHeaders
     *
     * @param  mixed $payload
     * @return array
     */
    private function prepareHeaders(array $payload): array
    {
        return [
            'Content-Type' => 'application/json',
        ];
    }
    
    /**
     * generateSignature
     *
     * @param  mixed $data
     * @param  mixed $requestId
     * @return string
     */
    private function generateSignature(array $data, $requestId = ""): string
    {
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
    
    /**
     * verifySignature
     *
     * @param  mixed $response
     * @return bool
     */
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
    
    /**
     * convertDataToString
     *
     * @param  mixed $data
     * @return string
     */
    private function convertDataToString(array $data): string
    {
        return implode('|',array_values($data));
    }
}
