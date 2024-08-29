<?php

namespace Postpay\Responses;

class DetailAccountResponse extends BaseResponse
{
    public function getAccountStatus(): ?string
    {
        return $this->getData()['accStat'] ?? null;
    }
}
