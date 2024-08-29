<?php

namespace Postpay\Responses;

class SearchTransactionResponse extends BaseResponse
{
    public function getTransactions(): array
    {
        return $this->getData()['content'] ?? [];
    }

    public function getTotalPages(): ?int
    {
        return $this->getData()['totalPage'] ?? null;
    }

    public function getTotalRecords(): ?int
    {
        return $this->getData()['totalRecord'] ?? null;
    }
}
