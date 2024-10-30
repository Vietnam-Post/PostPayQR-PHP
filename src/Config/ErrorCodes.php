<?php

/*****************************************************************************
 * @Author                : KienNguyen<letvn.com@gmail.com>                  *
 * @CreatedDate           : 2024-08-30 16:43:22                              *
 * @LastEditors           : KienNguyen<letvn.com@gmail.com>                  *
 * @LastEditDate          : 2024-08-30 16:43:41                              *
 * @FilePath              : packages/Postpay/src/config/ErrorCodes.php       *
 * @CopyRight             : VietNamPost (vietnampost.vn)                     *
 ****************************************************************************/

namespace Postpay\Config;

class ErrorCodes
{
    /**
     * getErrorMessages
     *
     * @return array
     */
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
            'QR-121' => 'Tổ chức chưa được cấu hình merchantId',
            'QR-098' => 'Lỗi hệ thống',
            'QR-099' => 'Lỗi không xác định',
            'QR-116' =>  'Mã đối tác không tồn tại',
            'QR-117' =>  'Đối tác không hoạt động',
            'QR-118' =>  'Tổ chức chưa được cấu hình channel',
            'QR-119' =>  'Không tìm thấy thông tin tài khoản',
            'QR-120' =>  'Không tìm thấy thông tin đơn hàng',
            'QR-121' =>  'Tổ chức chưa được cấu hình merchantId',
            'QR-122' =>  'Không tìm thấy thông tin giao dịch',
            'QR-123' =>  'Không tìm thấy thông tin cấu hình tài khoản hệ thống',
            'QR-124' =>  'Không tìm thấy thông tin cấu hình tài khoản thanh toán',

            // Hoàn trả 
            'CB-101' => 'Có lỗi xảy ra trong quá trình kết nối tới hệ thống ngân hàng. Vui lòng quay lại sau.',
            'CB-102' => 'Tài khoản ngân hàng của bạn không đủ số dư để thực hiện giao dịch. Vui lòng quay lại sau',
            'CB-104' => 'Hệ thống ngân hàng có lỗi trong quá trình xử lý. Vui lòng quay lại sau.',
            'CB-111' => 'Thẻ/ tài khoản của quý khách đang bị khoá, hoặc không ở trạng thái hoạt động. Vui lòng liên hệ với Ngân hàng để kiểm tra.',
            'CB-116' => 'Mã OTP không chính xác hoặc hết hạn sử dụng. Vui lòng thử lại',
            'CB-132' => 'Không tìm thấy thông tin giao dịch  trên hệ thống ngân hàng. Vui lòng kiểm tra lại.',
            'CB-139' => 'Giao dịch đã tồn tại trên hệ thống ngân hàng. Vui lòng kiểm tra lại.',
            'CB-178' => 'Có lỗi trong quá trình thực hiện giao dịch. Vui lòng thực hiện lại',
            'CB-218' => 'Dữ liệu gọi hàm không hợp lệ, vui lòng kiểm tra lại.',
            'CB-219' => 'Mã đối tác không tồn tại. Vui lòng kiểm tra lại.',
            'CB-220' => 'Giao dịch vượt quá hạn mức cho phép. Vui lòng kiểm tra lại.',
            'CB-221' => 'Có  lỗi tại ngân hàng phát hành. Vui lòng kiểm tra lại thông tin ngân hàng phát hành.',
            'CB-222' => 'Giá trị giao dịch không đúng so với giao dịch gốc',
            'CB-223' => 'Tổ chức tài chính không hợp lệ.',
            'CB-132' => 'Không tìm thấy thông tin giao dịch  trên hệ thống ngân hàng. Vui lòng kiểm tra lại.',
        ];
    }
}
