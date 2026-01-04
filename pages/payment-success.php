<?php
// payment-success.php در پوشه pages/
require_once '../php/config.php';

$tracking_code = $_GET['tracking'] ?? '';
$amount = $_GET['amount'] ?? 0;
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پرداخت موفق | گردشگر من</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .success-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            padding: 40px;
            max-width: 500px;
            width: 100%;
            text-align: center;
        }
        
        .success-icon {
            width: 100px;
            height: 100px;
            background: #4CAF50;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            color: white;
            font-size: 3rem;
        }
        
        .tracking-code {
            background: #e8f5e9;
            border: 2px dashed #4CAF50;
            padding: 15px;
            border-radius: 10px;
            font-family: monospace;
            font-size: 1.2rem;
            margin: 20px 0;
            direction: ltr;
            text-align: center;
        }
        
        .btn-success {
            background: #4CAF50;
            color: white;
            padding: 12px 30px;
            border-radius: 25px;
            text-decoration: none;
            display: inline-block;
            margin: 10px;
            border: none;
            transition: all 0.3s;
        }
        
        .btn-success:hover {
            background: #45a049;
            color: white;
            transform: translateY(-2px);
        }
        
        .btn-outline-success {
            border: 2px solid #4CAF50;
            color: #4CAF50;
            background: white;
            padding: 12px 30px;
            border-radius: 25px;
            text-decoration: none;
            display: inline-block;
            margin: 10px;
            transition: all 0.3s;
        }
        
        .btn-outline-success:hover {
            background: #4CAF50;
            color: white;
        }
        
        .payment-details {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        
        .payment-details p {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="success-card">
        <div class="success-icon">
            <i class="fas fa-check"></i>
        </div>
        
        <h2 class="text-success">پرداخت با موفقیت انجام شد!</h2>
        <p class="text-muted">سفارش شما ثبت و پرداخت آن تأیید شد.</p>
        
        <?php if ($tracking_code): ?>
        <div class="tracking-code">
            کد رهگیری: <?php echo htmlspecialchars($tracking_code); ?>
        </div>
        <?php endif; ?>
        
        <div class="payment-details">
            <?php if ($amount): ?>
            <p><strong>مبلغ پرداختی:</strong> <?php echo number_format($amount); ?> ریال</p>
            <?php endif; ?>
            <p><strong>تاریخ:</strong> <?php echo date('Y/m/d H:i'); ?></p>
            <p>رسید پرداخت به ایمیل شما ارسال خواهد شد.</p>
        </div>
        
        <div class="mt-4">
            <a href="../index.php" class="btn-success">
                <i class="fas fa-home me-2"></i>بازگشت به خانه
            </a>
            <a href="tours.php" class="btn-outline-success">
                <i class="fas fa-suitcase-rolling me-2"></i>مشاهده تورهای دیگر
            </a>
        </div>
        
        <div class="mt-4">
            <small class="text-muted">
                <i class="fas fa-info-circle me-1"></i>
                اطلاعات سفارش شما در پنل کاربری قابل مشاهده است.
            </small>
        </div>
    </div>
</body>
</html>