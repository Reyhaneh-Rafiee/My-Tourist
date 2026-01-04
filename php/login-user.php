<?php
session_start();
require('config.php');

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = mysqli_real_escape_string($connect, trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "ایمیل معتبر وارد کنید";
    }

    if (empty($password)) {
        $errors[] = "رمز عبور را وارد کنید";
    }

    if (empty($errors)) {
        $hashed_password = md5($password);

        $sql = "SELECT * FROM users WHERE email='$email' AND password='$hashed_password'";
        $result = mysqli_query($connect, $sql);

        if ($result && mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);

            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['fullname'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_type'] = 'user';

            // 🔴 ریدایرکت صحیح
            if (isset($_SESSION['redirect_after_login'])) {
                $redirect = $_SESSION['redirect_after_login'];
                unset($_SESSION['redirect_after_login']);
                header("Location: $redirect");
                exit;
            } else {
                header("Location: ../index.php");
                exit;
            }

        } else {
            $errors[] = "ایمیل یا رمز عبور اشتباه است";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود کاربر</title>
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
        .container { 
            background: white; 
            padding: 40px; 
            border-radius: 15px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.2); 
            max-width: 500px; 
            width: 100%;
        }
        .error-box {
            background: #f8d7da;
            color: #721c24;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #f5c6cb;
            margin-bottom: 20px;
        }
        .success-box {
            background: #d4edda;
            color: #155724;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #c3e6cb;
            margin-bottom: 20px;
        }
        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        input:focus {
            outline: none;
            border-color: #667eea;
        }
        .btn {
            background: linear-gradient(135deg, #4CAF50 0%, #2E7D32 100%);
            color: white;
            padding: 14px;
            border: none;
            border-radius: 5px;
            width: 100%;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }
        .btn:hover {
            opacity: 0.9;
        }
        .link-text {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }
        .link-text a {
            color: #667eea;
            text-decoration: none;
            font-weight: bold;
        }
        .forgot-password {
            text-align: left;
            margin-top: 10px;
        }
        .forgot-password a {
            color: #666;
            text-decoration: none;
            font-size: 14px;
        }
        .forgot-password a:hover {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>🔐 ورود به حساب کاربری</h2>
        
        <?php if(isset($_GET['registered']) && $_GET['registered'] == 'true'): ?>
            <div class="success-box">
                ✅ ثبت نام شما با موفقیت انجام شد. لطفاً وارد شوید.
            </div>
        <?php endif; ?>
        
        <?php if(!empty($errors)): ?>
            <div class="error-box">
                <h4 style="margin-top: 0;">❌ خطا در ورود:</h4>
                <ul style="padding-right: 20px;">
                    <?php foreach($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="email">ایمیل:</label>
                <input type="email" id="email" name="email" 
                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" 
                       required>
            </div>
            
            <div class="form-group">
                <label for="password">رمز عبور:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="forgot-password">
                <a href="forgot-password.php">رمز عبور خود را فراموش کرده‌اید؟</a>
            </div>
            
            <button type="submit" class="btn">ورود به حساب</button>
        </form>
        
        <div class="link-text">
            <p>حساب کاربری ندارید؟ <a href="register.php">ثبت نام کنید</a></p>
        </div>
    </div>
</body>
</html>