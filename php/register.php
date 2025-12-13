<?php
session_start();
require('config.php');

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // دریافت مقادیر
    $fullname = isset($_POST['txt']) ? mysqli_real_escape_string($connect, trim($_POST['txt'])) : '';
    $email = isset($_POST['email']) ? mysqli_real_escape_string($connect, trim($_POST['email'])) : '';
    $password = isset($_POST['pswd']) ? $_POST['pswd'] : '';
    $repeat_password = isset($_POST['repeat_pswd']) ? $_POST['repeat_pswd'] : '';
    
    // اعتبارسنجی
    if (empty($fullname)) {
        $errors[] = "نام و نام خانوادگی الزامی است";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "ایمیل معتبر وارد کنید";
    }
    
    if (empty($password) || strlen($password) < 6) {
        $errors[] = "رمز عبور باید حداقل 6 کاراکتر باشد";
    }
    
    if ($password !== $repeat_password) {
        $errors[] = "رمز عبور و تکرار آن یکسان نیستند";
    }
    
    // چک کردن تکراری نبودن ایمیل
    if (empty($errors)) {
        $check_email = "SELECT id FROM users WHERE email = '$email'";
        $result = mysqli_query($connect, $check_email);
        
        if (mysqli_num_rows($result) > 0) {
            $errors[] = "این ایمیل قبلا ثبت شده است";
        } else {
            // هش کردن رمز عبور (md5)
            $hashed_password = md5($password);
            $hashed_repeat = md5($repeat_password);
            
            // دقت کن: ستون در جدول repeat-password هست (با خط تیره)
            $sql = "INSERT INTO users (fullname, email, password, `repeat-password`) 
                    VALUES ('$fullname', '$email', '$hashed_password', '$hashed_repeat')";
            
            if (mysqli_query($connect, $sql)) {
                $success = "ثبت نام با موفقیت انجام شد!";
                
                // ذخیره اطلاعات در session
                $_SESSION['user_id'] = mysqli_insert_id($connect);
                $_SESSION['user_name'] = $fullname;
                $_SESSION['user_email'] = $email;
                $_SESSION['user_type'] = 'user';
                
                // هدایت به صفحه اصلی سایت
                echo '<script>
                    setTimeout(function() {
                        window.location.href = "../index.html";
                    }, 2000);
                </script>';
            } else {
                $errors[] = "خطا در ثبت نام: " . mysqli_error($connect);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>نتیجه ثبت نام</title>
    <style>
        body { 
            font-family: Tahoma; 
            background: #f0f2f5; 
            padding: 50px; 
            text-align: center; 
        }
        .result-box { 
            background: white; 
            padding: 30px; 
            border-radius: 10px; 
            box-shadow: 0 0 20px rgba(0,0,0,0.1); 
            max-width: 500px; 
            margin: 0 auto; 
        }
        .success { 
            color: green; 
            font-size: 18px; 
            margin: 20px 0; 
            padding: 15px;
            background: #e8f5e9;
            border-radius: 5px;
        }
        .error { 
            color: red; 
            margin: 20px 0; 
            padding: 15px;
            background: #ffebee;
            border-radius: 5px;
        }
        .btn { 
            background: #4CAF50; 
            color: white; 
            padding: 10px 20px; 
            text-decoration: none; 
            border-radius: 5px; 
            display: inline-block; 
            margin-top: 20px; 
            border: none;
            cursor: pointer;
        }
        ul {
            list-style-type: none;
            padding: 0;
            text-align: right;
        }
        li {
            margin: 5px 0;
            padding: 5px;
        }
    </style>
</head>
<body>
    <div class="result-box">
        <h2>نتیجه ثبت نام</h2>
        
        <?php if($success): ?>
            <div class="success">
                ✅ <?php echo $success; ?>
                <p>در حال هدایت به صفحه اصلی سایت...</p>
                <div style="margin-top: 20px;">
                    <div class="spinner"></div>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if(!empty($errors)): ?>
            <div class="error">
                ❌ خطا در ثبت نام
                <ul>
                    <?php foreach($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
                <a href="../pages/login-form.html" class="btn">بازگشت به صفحه ورود</a>
            </div>
        <?php endif; ?>
    </div>
    
    <style>
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #4CAF50;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</body>
</html>