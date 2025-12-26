<?php

require_once 'config.php';

// بررسی اگر تور مشخص نشده
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: tours.php");
    exit();
}

$tour_id = intval($_GET['id']);

// دریافت اطلاعات تور
$tour_sql = "SELECT * FROM tours WHERE t_id = ?";
$tour_stmt = $connect->prepare($tour_sql);
$tour_stmt->bind_param("i", $tour_id);
$tour_stmt->execute();
$tour_result = $tour_stmt->get_result();

if ($tour_result->num_rows == 0) {
    header("Location: tours.php");
    exit();
}

$tour = $tour_result->fetch_assoc();
$tour_stmt->close();
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>رزرو تور <?php echo htmlspecialchars($tour['title']); ?> | گردشگر من</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 80px;
            min-height: 100vh;
        }
        
        .reservation-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .tour-info {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
            padding: 25px;
        }
        
        .form-section {
            padding: 30px;
        }
        
        .step-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        
        .step {
            text-align: center;
            flex: 1;
            position: relative;
        }
        
        .step-number {
            width: 40px;
            height: 40px;
            background: #e9ecef;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-weight: bold;
        }
        
        .step.active .step-number {
            background: #11998e;
            color: white;
        }
        
        .step-title {
            font-size: 0.9rem;
            color: #6c757d;
        }
        
        .step.active .step-title {
            color: #11998e;
            font-weight: bold;
        }
        
        .form-group label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #495057;
        }
        
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 15px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: #11998e;
            box-shadow: 0 0 0 0.2rem rgba(17, 153, 142, 0.25);
        }
        
        .btn-submit {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1.1rem;
            width: 100%;
            margin-top: 20px;
            transition: all 0.3s;
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(17, 153, 142, 0.4);
        }
        
        .login-prompt {
            text-align: center;
            padding: 20px;
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .price-display {
            font-size: 1.5rem;
            font-weight: bold;
            color: #2c3e50;
            text-align: center;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            margin: 20px 0;
        }
        
        .alert {
            border-radius: 10px;
            border: none;
        }
    </style>
</head>
<body>
    <!-- نوار هدر -->
    <nav class="navbar navbar-expand-lg fixed-top navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="../index.html">
                <i class="fas fa-suitcase-rolling me-2"></i>
                گردشگر من
            </a>
            <div>
                <a href="tours.php" class="btn btn-outline-secondary me-2">
                    <i class="fas fa-arrow-right"></i> بازگشت به تورها
                </a>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <div class="reservation-container">
            <!-- اطلاعات تور -->
            <div class="tour-info">
                <h2 class="mb-3"><?php echo htmlspecialchars($tour['title']); ?></h2>
                <div class="row">
                    <div class="col-md-6">
                        <p><i class="fas fa-map-marker-alt me-2"></i> مقصد: <?php echo htmlspecialchars($tour['destination'] ?? 'ایران'); ?></p>
                    </div>
                    <div class="col-md-6 text-left">
                        <h3 class="mb-0"><?php echo number_format($tour['price']); ?> ریال</h3>
                        <small>به ازای هر نفر</small>
                    </div>
                </div>
            </div>
            
            <!-- فرم رزرو -->
            <div class="form-section">
                <!-- نمایشگر مراحل -->
                <div class="step-indicator">
                    <div class="step active">
                        <div class="step-number">1</div>
                        <div class="step-title">اطلاعات شخصی</div>
                    </div>
                    <div class="step">
                        <div class="step-number">2</div>
                        <div class="step-title">تأیید و پرداخت</div>
                    </div>
                </div>
                
                <?php if (!isLoggedIn()): ?>
                    <!-- پیام برای کاربران وارد نشده -->
                    <div class="login-prompt">
                        <i class="fas fa-exclamation-circle fa-lg me-2"></i>
                        برای رزرو تور باید وارد حساب کاربری خود شوید یا ثبت نام کنید.
                        <div class="mt-3">
                            <a href="register-form.html" class="btn btn-primary me-2">
                                <i class="fas fa-user-plus"></i> ثبت نام
                            </a>
                            <a href="register-form.html" class="btn btn-outline-primary">
                                <i class="fas fa-sign-in-alt"></i> ورود
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- فرم رزرو برای کاربران وارد شده -->
                    <form id="reservationForm" action="process-reservation.php" method="POST">
                        <input type="hidden" name="tour_id" value="<?php echo $tour_id; ?>">
                        <input type="hidden" name="tour_price" value="<?php echo $tour['price']; ?>">
                        
                        <div class="price-display">
                            <span>مبلغ قابل پرداخت: </span>
                            <span class="text-success"><?php echo number_format($tour['price']); ?> ریال</span>
                        </div>
                        
                        <!-- اطلاعات کاربر از دیتابیس -->
                        <?php
                        $user_id = getCurrentUser();
                        $user_sql = "SELECT * FROM users WHERE id = ?";
                        $user_stmt = $connect->prepare($user_sql);
                        $user_stmt->bind_param("i", $user_id);
                        $user_stmt->execute();
                        $user_result = $user_stmt->get_result();
                        $user = $user_result->fetch_assoc();
                        $user_stmt->close();
                        ?>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name">نام و نام خانوادگی</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="phone">شماره تماس</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" 
                                           value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="email">آدرس ایمیل</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="code">کد ملی</label>
                                    <input type="text" class="form-control" id="code" name="code" 
                                           value="<?php echo htmlspecialchars($user['national_code'] ?? ''); ?>" required maxlength="10">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="address">آدرس کامل</label>
                            <textarea class="form-control" id="address" name="address" rows="3" required><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="travelers">تعداد مسافران</label>
                                    <select class="form-control" id="travelers" name="travelers" required>
                                        <option value="1">1 نفر</option>
                                        <option value="2">2 نفر</option>
                                        <option value="3">3 نفر</option>
                                        <option value="4">4 نفر</option>
                                        <option value="5">5 نفر</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="travel_date">تاریخ سفر (اختیاری)</label>
                                    <input type="date" class="form-control" id="travel_date" name="travel_date">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group mb-4">
                            <label for="notes">ملاحظات و درخواست‌های ویژه</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="هر گونه درخواست خاص یا نیازهای ویژه را اینجا بنویسید..."></textarea>
                        </div>
                        
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-credit-card me-2"></i>
                            ادامه به مرحله پرداخت
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- اسکریپت‌ها -->
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script>
    // محاسبه قیمت بر اساس تعداد مسافران
    document.getElementById('travelers').addEventListener('change', function() {
        const pricePerPerson = <?php echo $tour['price']; ?>;
        const travelers = this.value;
        const totalPrice = pricePerPerson * travelers;
        
        document.querySelector('.price-display span.text-success').textContent = 
            totalPrice.toLocaleString('fa-IR') + ' ریال';
    });
    
    // اعتبارسنجی فرم
    document.getElementById('reservationForm').addEventListener('submit', function(e) {
        const name = document.getElementById('name').value;
        const phone = document.getElementById('phone').value;
        const code = document.getElementById('code').value;
        
        if (!name || !phone || !code) {
            e.preventDefault();
            alert('لطفا تمام فیلدهای ضروری را پر کنید.');
            return false;
        }
        
        if (code.length !== 10) {
            e.preventDefault();
            alert('کد ملی باید ۱۰ رقم باشد.');
            return false;
        }
        
        // ادامه پرداخت
        return true;
    });
    </script>
</body>
</html>
<?php $connect->close(); ?>