<?php

namespace Postpay\Responses;

class CreateAccountResponse extends BaseResponse
{
    public function getAccountNumber(): ?string
    {
        return $this->getData()['accNo'] ?? null;
    }
}
