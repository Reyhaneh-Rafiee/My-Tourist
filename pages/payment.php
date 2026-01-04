<?php
require_once 'config.php';

if (!isLoggedIn() || !isset($_SESSION['order_id'])) {
    header("Location: tours.php");
    exit();
}

$order_id = intval($_SESSION['order_id']);
$user_id = getCurrentUser();


// دریافت اطلاعات سفارش
$sql = "SELECT o.*, t.title as tour_title 
        FROM orders o 
        LEFT JOIN tours t ON o.t_id = t.t_id 
        WHERE o.o_id = ? AND o.user_id = ?";
$stmt = mysqli_prepare($connect, $sql);
mysqli_stmt_bind_param($stmt, "ii", $order_id, $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
    header("Location: tours.php");
    exit();
}

$order = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پرداخت | گردشگر من</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
            padding-top: 60px;
        }
        
        .payment-container {
            max-width: 600px;
            margin: 0 auto;
        }
        
        .payment-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .payment-header {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
            padding: 25px;
            text-align: center;
        }
        
        .order-summary {
            padding: 25px;
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }
        
        .payment-body {
            padding: 30px;
        }
        
        .payment-methods {
            margin-bottom: 25px;
        }
        
        .payment-method {
            border: 2px solid #dee2e6;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .payment-method:hover,
        .payment-method.selected {
            border-color: #11998e;
            background-color: rgba(17, 153, 142, 0.05);
        }
        
        .method-logo {
            width: 60px;
            height: 40px;
            background: #f8f9fa;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 15px;
            color: #495057;
            font-size: 1.5rem;
        }
        
        .btn-pay {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1.1rem;
            width: 100%;
            transition: all 0.3s;
        }
        
        .btn-pay:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(17, 153, 142, 0.4);
        }
        
        .tracking-code {
            background: #e3f2fd;
            border: 1px dashed #2196f3;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            font-family: monospace;
            font-size: 1.2rem;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="../index.html">
                <i class="fas fa-suitcase-rolling me-2"></i>
                گردشگر من
            </a>
        </div>
    </nav>

    <div class="container py-4">
        <div class="payment-container">
            <div class="payment-card">
                <div class="payment-header">
                    <h2 class="mb-0">پرداخت اینترنتی</h2>
                    <p class="mb-0 mt-2">لطفا روش پرداخت را انتخاب کنید</p>
                </div>
                
                <div class="order-summary">
                    <h5>خلاصه سفارش</h5>
                    <div class="row">
                        <div class="col-6">
                            <small class="text-muted">تور:</small>
                            <p class="mb-1"><?php echo htmlspecialchars($order['tour_title'] ?? 'تور'); ?></p>
                        </div>
                        <div class="col-6 text-left">
                            <small class="text-muted">مبلغ قابل پرداخت:</small>
                            <p class="mb-1 h5 text-success"><?php echo number_format($order['total_price']); ?> ریال</p>
                        </div>
                    </div>
                    <div class="tracking-code">
                        کد رهگیری: <?php echo htmlspecialchars($order['tracking_code']); ?>
                    </div>
                </div>
                
                <div class="payment-body">
                    <form id="paymentForm" action="process-payment.php" method="POST">
                        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                        
                        <div class="payment-methods">
                            <div class="payment-method selected" onclick="selectMethod(1)">
                                <div class="d-flex align-items-center">
                                    <div class="method-logo">
                                        <i class="fas fa-credit-card"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">پرداخت با کارت بانکی</h6>
                                        <small class="text-muted">کلیه کارت‌های عضو شتاب</small>
                                    </div>
                                    <input type="radio" name="payment_method" value="card" checked style="display: none;">
                                </div>
                            </div>
                            
                            <div class="payment-method" onclick="selectMethod(2)">
                                <div class="d-flex align-items-center">
                                    <div class="method-logo">
                                        <i class="fas fa-university"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">پرداخت آنلاین</h6>
                                        <small class="text-muted">درگاه پرداخت امن</small>
                                    </div>
                                    <input type="radio" name="payment_method" value="online" style="display: none;">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group mb-4">
                            <label for="card_number">شماره کارت (برای تست: 6037991234567890)</label>
                            <input type="text" class="form-control" id="card_number" name="card_number" 
                                   placeholder="۶۲۱۹-۸۶۱۱-۱۲۳۴-۵۶۷۸" maxlength="19" value="6037991234567890">
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="expire_date">تاریخ انقضا (برای تست: 12/30)</label>
                                    <input type="text" class="form-control" id="expire_date" name="expire_date" 
                                           placeholder="MM/YY" maxlength="5" value="12/30">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cvv2">CVV2 (برای تست: 123)</label>
                                    <input type="password" class="form-control" id="cvv2" name="cvv2" 
                                           placeholder="۱۲۳" maxlength="4" value="123">
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn-pay">
                            <i class="fas fa-lock me-2"></i>
                            پرداخت و نهایی کردن خرید
                        </button>
                        
                        <div class="text-center mt-3">
                            <small class="text-muted">
                                <i class="fas fa-shield-alt me-1"></i>
                                کلیه پرداخت‌ها به صورت امن و رمزنگاری شده انجام می‌شود.
                            </small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    // انتخاب روش پرداخت
    function selectMethod(methodNumber) {
        // حذف انتخاب قبلی
        document.querySelectorAll('.payment-method').forEach(method => {
            method.classList.remove('selected');
        });
        
        // انتخاب جدید
        const methodElement = document.querySelectorAll('.payment-method')[methodNumber - 1];
        methodElement.classList.add('selected');
        
        // تنظیم radio button
        const radioInput = methodElement.querySelector('input[type="radio"]');
        radioInput.checked = true;
    }
    
    // فرمت شماره کارت
    document.getElementById('card_number').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        value = value.replace(/(\d{4})(?=\d)/g, '$1-');
        e.target.value = value.substring(0, 19);
    });
    
    // فرمت تاریخ انقضا
    document.getElementById('expire_date').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length >= 2) {
            value = value.substring(0, 2) + '/' + value.substring(2);
        }
        e.target.value = value.substring(0, 5);
    });
    
    // اعتبارسنجی فرم
    document.getElementById('paymentForm').addEventListener('submit', function(e) {
        const cardNumber = document.getElementById('card_number').value.replace(/\D/g, '');
        const expireDate = document.getElementById('expire_date').value;
        const cvv2 = document.getElementById('cvv2').value;
        const totalPrice = <?php echo $order['total_price']; ?>;
        
        if (cardNumber.length !== 16) {
            e.preventDefault();
            alert('شماره کارت باید ۱۶ رقم باشد.');
            return false;
        }
        
        if (expireDate.length !== 5) {
            e.preventDefault();
            alert('تاریخ انقضا را به فرمت MM/YY وارد کنید.');
            return false;
        }
        
        if (cvv2.length < 3 || cvv2.length > 4) {
            e.preventDefault();
            alert('کد CVV2 باید ۳ یا ۴ رقم باشد.');
            return false;
        }
        
        // شبیه‌سازی پرداخت
        if(confirm('آیا از پرداخت مبلغ ' + totalPrice.toLocaleString('fa-IR') + ' ریال اطمینان دارید؟')) {
            // ادامه
            return true;
        } else {
            e.preventDefault();
            return false;
        }
    });
    </script>
</body>
</html>
<?php mysqli_close($connect); ?>