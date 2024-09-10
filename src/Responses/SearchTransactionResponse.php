<?php
/*****************************************************************************
 * @Author                : KienNguyen<kiennt@vnpost.vn>                     *
 * @CreatedDate           : 2024-08-30 16:49:15                              *
 * @LastEditors           : KienNguyen<kiennt@vnpost.vn>                     *
 * @LastEditDate          : 2024-09-10 10:19:41                              *
 * @FilePath              : SearchTransactionResponse.php                    *
 * @CopyRight             : VietNamPost (vietnampost.vn)                     *
 ****************************************************************************/

namespace Postpay\Responses;

class SearchTransactionResponse extends BaseResponse
{    
    /**
     * getTransactions
     *
     * @return array
     */
    public function getTransactions(): array
    {
        return $this->getData()['content'] ?? [];
    }
    
    /**
     * getTotalPages
     *
     * @return int
     */
    public function getTotalPages(): ?int
    {
        return $this->getData()['totalPage'] ?? null;
    }
    
    /**
     * getTotalRecords
     *
     * @return int
     */
    public function getTotalRecords(): ?int
    {
        return $this->getData()['totalRecord'] ?? null;
    }
}
