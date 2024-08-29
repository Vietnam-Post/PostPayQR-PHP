<?php

namespace Postpay\Responses;

class CloseAccountResponse extends BaseResponse
{
    public function getCloseDate(): ?string
    {
        return $this->getData()['closeDate'] ?? null;
    }
}
