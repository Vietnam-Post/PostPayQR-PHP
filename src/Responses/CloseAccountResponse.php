<?php
/*****************************************************************************
 * @Author                : KienNguyen<kiennt@vnpost.vn>                     *
 * @CreatedDate           : 2024-08-30 16:47:02                              *
 * @LastEditors           : KienNguyen<kiennt@vnpost.vn>                     *
 * @LastEditDate          : 2024-08-30 16:47:08                              *
 * @FilePath              : CloseAccountResponse.php                         *
 * @CopyRight             : VietNamPost (vietnampost.vn)                     *
 ****************************************************************************/

namespace Postpay\Responses;

class CloseAccountResponse extends BaseResponse
{
    public function getCloseDate(): ?string
    {
        return $this->getData()['closeDate'] ?? null;
    }
}
