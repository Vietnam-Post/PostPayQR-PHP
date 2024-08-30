<?php
/*****************************************************************************
 * @Author                : KienNguyen<kiennt@vnpost.vn>                     *
 * @CreatedDate           : 2024-08-30 16:48:37                              *
 * @LastEditors           : KienNguyen<kiennt@vnpost.vn>                     *
 * @LastEditDate          : 2024-08-30 16:48:46                              *
 * @FilePath              : CreateAccountResponse.php                        *
 * @CopyRight             : VietNamPost (vietnampost.vn)                     *
 ****************************************************************************/

namespace Postpay\Responses;

class CreateAccountResponse extends BaseResponse
{
    public function getAccountNumber(): ?string
    {
        return $this->getData()['accNo'] ?? null;
    }
}
