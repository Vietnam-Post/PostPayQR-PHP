<?php

namespace Postpay\Config;

class ErrorCodes
{
    public static function getErrorMessages(): array
    {
        return [
            '01' => 'ACCOUNT_EXISTED - Tài khoản đã tồn tại.',
            '02' => 'ACCOUNT_NUMBER_INVALID - Số tài khoản không hợp lệ.',
            '03' => 'CAN_NOT_CREATE_ACCOUNT - Không thể tạo tài khoản.',
            '04' => 'ACCOUNT_TYPE_INVALID - Loại tài khoản không hợp lệ.',
            '05' => 'ACCOUNT_NO_PURE_INVALID - Cấu hình khởi tạo tài khoản không hợp lệ.',
            '06' => 'ACCOUNT_NO_CONFLICT - Thông tin khởi tạo tài khoản có xung đột trong request.',
            '07' => 'ACCOUNT_NAME_INVALID - Tên tài khoản không hợp lệ.',
            '10' => 'PARTNER_NOT_FOUND - Không tìm thấy tên đối tác.',
            '11' => 'MERCHANT_NOT_FOUND - Không tìm thấy tên merchant.',
            '12' => 'PARTNER_OR_MERCHANT_INVALID - Đối tác không hợp lệ.',
            '13' => 'PARTNER_ACCOUNT_INVALID - Tài khoản đối tác không hợp lệ.',
            '14' => 'PARTNER_ACCOUNT_NOT_FOUND - Không tìm thấy tài khoản đối tác.',
            '15' => 'FIXED_AMOUNT_INVALID - Số tiền cần thu hộ không hợp lệ.',
            '16' => 'PARTNER_MAINTAIN_ERR - Lỗi bảo trì tài khoản đối tác.',
            '20' => 'REQUEST_ID_INVALID - Request Id không hợp lệ.',
            '22' => 'REQUEST_ID_DUPLICATE - Request Id bị trùng.',
            '98' => 'EXCEPTION - Lỗi hệ thống.',
            '99' => 'ERROR_UNKNOWN - Lỗi không xác định.'
        ];
    }
}
