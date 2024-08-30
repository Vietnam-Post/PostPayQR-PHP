# Postpay API PHP Client

Postpay API PHP Client là một thư viện PHP dùng để tích hợp với Postpay API, cho phép bạn quản lý tài khoản chuyên thu và thực hiện các thao tác liên quan như tạo tài khoản, đóng tài khoản, truy vấn giao dịch, và xử lý callback. Thư viện này có thể sử dụng với nhiều framework PHP khác nhau, bao gồm Laravel và này nọ.

## Tính năng

- Tạo tài khoản chuyên thu
- Đóng tài khoản không sử dụng
- Xem chi tiết thông tin tài khoản
- Truy vấn giao dịch tài khoản chuyên thu
- Xử lý callback từ Postpay API
- Hỗ trợ mã lỗi và mô tả lỗi chi tiết

## Cài đặt

```bash
composer require vnpost/postpay-php
```

## Cấu hình
Trước khi sử dụng, bạn cần cấu hình một số thông tin cần thiết như chế độ hoạt động (dev/prod), đường dẫn đến file chứng chỉ API (.cer), và mã đối tác.

### Laravel
Nếu bạn sử dụng Laravel, bạn có thể thêm các biến cấu hình vào file .env:
```bash
POSTPAY_MODE=dev # hoặc prod
POSTPAY_API_KEY_PATH=/path/to/key.cer
POSTPAY_PARTNER_CODE=your_partner_code
POSTPAY_PARTNER_PRIVATE_KEY_PATH=/path/to/partner_private_key_path.pem
### Framework php khác
```bash
[POSTPAY]
MODE=dev # hoặc prod
API_KEY_PATH=/path/to/key.cer
PARTNER_CODE=your_partner_code
PARTNER_PRIVATE_KEY_PATH=/path/to/partner_private_key_path.pem
```
Sau đó, trong mã của bạn, khởi tạo client như sau (dùng chung cả Laravel và Framework khác):
```bash
use Postpay\PostpayClient;

class PostpayController extends Controller
{
    public function createAccount(PostpayClient $postpayClient)
    {
        $data = input('post.'); // Thay chỗ này phù hợp với từng Framework
        $response = $postpayClient->createAccount($data);

        if ($response->getErrorCode()) {
            return json(['error' => $response->getErrorMessage()], 400);
        }

        return json($response->getData());
    }
}
```