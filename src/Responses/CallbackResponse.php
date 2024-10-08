<?php
/*****************************************************************************
 * @Author                : KienNguyen<kiennt@vnpost.vn>                     *
 * @CreatedDate           : 2024-08-30 16:47:55                              *
 * @LastEditors           : KienNguyen<kiennt@vnpost.vn>                     *
 * @LastEditDate          : 2024-09-10 10:19:14                              *
 * @FilePath              : CallbackResponse.php                             *
 * @CopyRight             : VietNamPost (vietnampost.vn)                     *
 ****************************************************************************/

namespace Postpay\Responses;

class CallbackResponse extends BaseResponse
{    
    /**
     * getTransactionId
     *
     * @return string
     */
    public function getTransactionId(): ?string
    {
        return $this->getData()['transId'] ?? null;
    }
}