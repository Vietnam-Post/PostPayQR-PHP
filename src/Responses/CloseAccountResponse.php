<?php
/*****************************************************************************
 * @Author                : KienNguyen<kiennt@vnpost.vn>                     *
 * @CreatedDate           : 2024-08-30 16:47:02                              *
 * @LastEditors           : KienNguyen<kiennt@vnpost.vn>                     *
 * @LastEditDate          : 2024-09-10 10:19:20                              *
 * @FilePath              : CloseAccountResponse.php                         *
 * @CopyRight             : VietNamPost (vietnampost.vn)                     *
 ****************************************************************************/

namespace Postpay\Responses;

class CloseAccountResponse extends BaseResponse
{    
    /**
     * getCloseDate
     *
     * @return string
     */
    public function getCloseDate(): ?string
    {
        return $this->getData()['closeDate'] ?? null;
    }
}
