<?php

namespace Postpay\Responses;

class CallbackResponse extends BaseResponse
{
    public function getTransactionId(): ?string
    {
        return $this->getData()['transId'] ?? null;
    }
}
