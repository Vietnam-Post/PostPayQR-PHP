<?php
/*****************************************************************************
 * @Author                : KienNguyen<kiennt@vnpost.vn>                     *
 * @CreatedDate           : 2024-08-30 16:48:56                              *
 * @LastEditors           : KienNguyen<kiennt@vnpost.vn>                     *
 * @LastEditDate          : 2024-08-30 16:49:05                              *
 * @FilePath              : DetailAccountResponse.php                        *
 * @CopyRight             : VietNamPost (vietnampost.vn)                     *
 ****************************************************************************/

namespace Postpay\Responses;

class DetailAccountResponse extends BaseResponse
{
    public function getAccountStatus(): ?string
    {
        return $this->getData()['accStat'] ?? null;
    }
}
