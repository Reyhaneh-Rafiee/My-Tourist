<?php
session_start();
require('config.php');

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // دریافت مقادیر
    $name = isset($_POST['txt']) ? mysqli_real_escape_string($connect, trim($_POST['txt'])) : '';
    $admin_id = isset($_POST['id']) ? mysqli_real_escape_string($connect, trim($_POST['id'])) : '';
    $password = isset($_POST['pswd']) ? $_POST['pswd'] : '';
    
    // اعتبارسنجی
    if (empty($name)) {
        $errors[] = "نام ادمین الزامی است";
    }
    
    if (empty($admin_id)) {
        $errors[] = "شناسه (ID) الزامی است";
    }
    
    if (empty($password)) {
        $errors[] = "رمز عبور الزامی است";
    }
    
    // اگر خطایی نبود
    if (empty($errors)) {
        // دو روش بررسی رمز عبور:
        // 1. اگر رمز در دیتابیس به صورت md5 ذخیره شده
        $hashed_password = md5($password);
        
        // 2. اگر رمز در دیتابیس به صورت plain text ذخیره شده
        $plain_password = $password;
        
        // جستجو در جدول admin با هر دو روش
        $sql = "SELECT * FROM admin 
                WHERE name = '$name' 
                AND (password = '$hashed_password' OR password = '$plain_password')";
        
        $result = mysqli_query($connect, $sql);
        
        if (!$result) {
            $errors[] = "خطا در اجرای کوئری: " . mysqli_error($connect);
        } elseif (mysqli_num_rows($result) == 1) {
            $admin = mysqli_fetch_assoc($result);
            
            // چک کن که id ورودی با id در دیتابیس مطابقت داره
            if ($admin_id == $admin['id']) {
                // رمز عبور رو اگه plain text بود، به md5 تبدیل کن و ذخیره کن
                if ($admin['password'] == $plain_password) {
                    // آپدیت کن به md5 برای امنیت بیشتر
                    $update_sql = "UPDATE admin SET password = '$hashed_password' WHERE id = {$admin['id']}";
                    mysqli_query($connect, $update_sql);
                }
                
                // ذخیره اطلاعات در session
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_name'] = $admin['name'];
                $_SESSION['user_type'] = 'admin';
                
                // هدایت به پنل ادمین
                header("Location: ../panel-admin/index.html");
                exit();
            } else {
                $errors[] = "شناسه (ID) صحیح نیست";
            }
        } else {
            $errors[] = "نام ادمین یا رمز عبور اشتباه است";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>نتیجه ورود ادمین</title>
    <style>
        body { 
            font-family: Tahoma; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .result-box { 
            background: white; 
            padding: 40px; 
            border-radius: 15px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.2); 
            max-width: 500px; 
            width: 100%;
            text-align: center;
        }
        .error { 
            color: #dc3545; 
            margin: 20px 0; 
            padding: 20px;
            background: #ffebee;
            border-radius: 10px;
            border-right: 5px solid #dc3545;
        }
        .success { 
            color: #28a745; 
            margin: 20px 0; 
            padding: 20px;
            background: #d4edda;
            border-radius: 10px;
            border-right: 5px solid #28a745;
        }
        .btn { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white; 
            padding: 12px 30px; 
            text-decoration: none; 
            border-radius: 25px; 
            display: inline-block; 
            margin-top: 20px; 
            border: none;
            cursor: pointer;
            font-family: Tahoma;
            font-size: 16px;
            transition: transform 0.3s;
        }
        .btn:hover {
            transform: translateY(-2px);
            color: white;
        }
        ul {
            list-style-type: none;
            padding: 0;
            text-align: right;
            margin: 15px 0;
        }
        li {
            margin: 8px 0;
            padding: 8px 15px;
            background: rgba(255,255,255,0.9);
            border-radius: 5px;
            display: flex;
            align-items: center;
        }
        li:before {
            content: "⚠️";
            margin-left: 10px;
        }
        h2 {
            color: #333;
            margin-bottom: 25px;
            font-size: 24px;
        }
        .info-box {
            background: #e7f3ff;
            border-radius: 10px;
            padding: 15px;
            margin: 20px 0;
            text-align: right;
            border-right: 5px solid #2196F3;
        }
    </style>
</head>
<body>
    <div class="result-box">
        <h2>نتیجه ورود ادمین</h2>
        
        <?php if(!empty($errors)): ?>
            <div class="error">
                <div style="font-size: 40px; margin-bottom: 10px;">❌</div>
                <h3 style="margin-top: 0; color: #dc3545;">خطا در ورود</h3>
                <ul>
                    <?php foreach($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
                
                <div class="info-box">
                    <strong>راهنمای ورود:</strong><br>
                    • نام ادمین: <strong>admin</strong><br>
                    • شناسه (ID): <strong>1</strong><br>
                    • رمز عبور: <strong>123</strong>
                </div>
                
                <a href="../pages/login-form.html" class="btn">
                    <i class="fas fa-arrow-right" style="margin-left: 8px;"></i>
                    بازگشت به صفحه ورود
                </a>
                
                <div style="margin-top: 20px; font-size: 14px; color: #666;">
                    <p>اگر مشکل ادامه دارد، لطفاً:</p>
                    <ol style="text-align: right; padding-right: 20px;">
                        <li>به phpMyAdmin بروید</li>
                        <li>جدول admin را بررسی کنید</li>
                        <li>رمز عبور را به MD5 تبدیل کنید</li>
                    </ol>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if(empty($_POST) && empty($errors)): ?>
            <div class="error">
                <div style="font-size: 40px; margin-bottom: 10px;">🔍</div>
                <h3 style="margin-top: 0; color: #ff9800;">فرم ارسال نشده</h3>
                <p>لطفاً از طریق فرم ورود اقدام کنید.</p>
                <a href="../pages/login-form.html" class="btn">رفتن به صفحه ورود</a>
            </div>
        <?php endif; ?>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
</body>
</html>