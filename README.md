# Postpay API PHP Client

Postpay API PHP Client là một thư viện PHP dùng để tích hợp với Postpay API, cho phép bạn quản lý tài khoản chuyên thu và thực hiện các thao tác liên quan như tạo tài khoản, đóng tài khoản, truy vấn giao dịch, và xử lý callback. Thư viện này có thể sử dụng với nhiều framework PHP khác nhau, bao gồm Laravel và ThinkPHP.

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
```
Sau đó, trong mã của bạn, khởi tạo client như sau:
```bash
use Postpay\PostpayClient;

$postpay = new PostpayClient(
    env('POSTPAY_MODE', 'dev'),
    env('POSTPAY_API_KEY_PATH'),
    env('POSTPAY_PARTNER_CODE')
);

$response = $postpay->createAccount($request->all());
```

### ThinkPHP hoặc các framework php khác
```bash
[POSTPAY]
MODE=dev # hoặc prod
API_KEY_PATH=/path/to/key.cer
PARTNER_CODE=your_partner_code
```
Sau đó, trong mã của bạn, khởi tạo client như sau:
```bash
use Postpay\PostpayClient;

class PostpayController extends Controller
{
    protected $postpayClient;

    public function __construct()
    {
        $this->postpayClient = new PostpayClient(
            config('postpay.mode', 'dev'),
            config('postpay.api_key_path'),
            config('postpay.partner_code')
        );
    }

    public function createAccount()
    {
        $data = input('post.');
        $response = $this->postpayClient->createAccount($data);

        if ($response->getErrorCode()) {
            return json(['error' => $response->getErrorMessage()], 400);
        }

        return json($response->getData());
    }
}
```