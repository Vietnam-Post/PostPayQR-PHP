<?php

namespace Postpay\Config;

class ErrorCodes
{
    public static function getErrorMessages(): array
    {
        return [
            'API000' => 'Thành công',
            'QR-001' => 'Không tìm thấy thông tin phù hợp',
            'QR-002' => 'Có lỗi trong quá trình đóng tài khoản',
            'QR-004' => 'Giao dịch hạch toán chưa rõ kết quả',
            'QR-005' => 'Giao dịch hạch toán bị lỗi',
            'QR-006' => 'Chưa cấu hình tài khoản thanh toán cho Bưu điện tỉnh',
            'QR-007' => 'Số tài khoản đã tồn tại ở một bưu cục khác',
            'QR-008' => 'Tên tài khoản đã tồn tại ở một bưu cục khác',
            'QR-009' => 'Tài khoản đã ngừng hoạt động',
            'QR-010' => 'Đã tồn tại mã QR của nhóm được chọn',
            'QR-011' => 'Giao dịch đang tồn tại yêu cầu xử lý sự vụ',
            'QR-012' => 'Giao dịch không có yêu cầu xử lý sự vụ',
            'QR-013' => 'Dữ liệu không hợp lệ',
            'QR-014' => 'Merchant chưa được cấu hình staffId',
            'QR-015' => 'Không tìm thấy thông tin tổ chức',
            'QR-016' => 'Tên tài khoản không hợp lệ',
            'QR-017' => 'Loại tài khoản không hợp lệ',
            'QR-018' => 'Số tiền không hợp lệ',
            'QR-019' => 'RequestID không hợp lệ',
            'QR-020' => 'RequestID bị trùng',
            'QR-098' => 'Lỗi hệ thống',
            'QR-099' => 'Lỗi không xác định'
        ];
    }
}
