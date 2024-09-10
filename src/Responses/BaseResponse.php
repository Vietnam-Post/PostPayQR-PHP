<?php
/*****************************************************************************
 * @Author                : KienNguyen<kiennt@vnpost.vn>                     *
 * @CreatedDate           : 2024-08-30 16:47:26                              *
 * @LastEditors           : KienNguyen<kiennt@vnpost.vn>                     *
 * @LastEditDate          : 2024-09-10 10:19:07                              *
 * @FilePath              : BaseResponse.php                                 *
 * @CopyRight             : VietNamPost (vietnampost.vn)                     *
 ****************************************************************************/

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
    }
    
    /**
     * getData
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->response['body'] ?? [];
    }
    
    /**
     * getErrorCode
     *
     * @return string
     */
    public function getErrorCode(): ?string
    {
        return $this->response['code'] ?? null;
    }
    
    /**
     * getErrorMessage
     *
     * @return string
     */
    public function getErrorMessage(): ?string
    {
        $code = $this->getErrorCode();
        return $this->errorCodes[$code] ?? 'Unknown error';
    }
    
    /**
     * isSuccess
     *
     * @return bool
     */
    public function isSuccess(): bool
    {
        // Kiểm tra nếu có lỗi trong phản hồi
        if ($this->getErrorCode()) {
            return false;
        }

        // Kiểm tra chữ ký
        return $this->verifySignature();
    }
    
    /**
     * getSignature
     *
     * @return string
     */
    private function getSignature(): ?string
    {
        return $this->response['signature'] ?? null;
    }
    
    /**
     * verifySignature
     *
     * @return bool
     */
    private function verifySignature(): bool
    {
        $signature = $this->getSignature();

        if (!$signature) {
            throw new \Exception('Signature not found in response');
        }

        return $this->postpayClient->verifySignature($this->response);
    }
}
