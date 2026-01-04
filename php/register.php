<?php
session_start();
require('config.php');

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $fullname = mysqli_real_escape_string($connect, trim($_POST['fullname'] ?? ''));
    $email = mysqli_real_escape_string($connect, trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $repeat_password = $_POST['repeat_password'] ?? '';

    if (empty($fullname)) $errors[] = "نام الزامی است";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "ایمیل معتبر نیست";
    if (strlen($password) < 6) $errors[] = "رمز عبور حداقل ۶ کاراکتر";
    if ($password !== $repeat_password) $errors[] = "رمزها یکسان نیستند";

    if (empty($errors)) {

        $check = mysqli_query($connect, "SELECT id FROM users WHERE email='$email'");
        if (mysqli_num_rows($check) > 0) {
            $errors[] = "این ایمیل قبلاً ثبت شده است";
        } else {
            $hashed = md5($password);

            $sql = "INSERT INTO users (fullname, email, password) 
                    VALUES ('$fullname','$email','$hashed')";

            if (mysqli_query($connect, $sql)) {
                $success = true;
                header("Location: login-user.php");
                exit;
            } else {
                $errors[] = "خطا در ثبت نام";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ثبت نام کاربر</title>
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
        .success-box {
            background: #d4edda;
            color: #155724;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #c3e6cb;
            text-align: center;
            margin-bottom: 20px;
        }
        .error-box {
            background: #f8d7da;
            color: #721c24;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #f5c6cb;
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        }
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #4CAF50;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 10px auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>📝 ثبت نام کاربر جدید</h2>
        
        <?php if($success): ?>
            <div class="success-box">
                <h3 style="margin-top: 0;">✅ <?php echo $success; ?></h3>
                <p>در حال هدایت به صفحه ورود...</p>
                <div class="spinner"></div>
                <p style="font-size: 14px; margin-top: 15px;">
                    اگر هدایت نشدید، <a href="login-user.php">اینجا کلیک کنید</a>
                </p>
            </div>
        <?php endif; ?>
        
        <?php if(!empty($errors)): ?>
            <div class="error-box">
                <h4 style="margin-top: 0;">❌ خطاهای زیر رخ داد:</h4>
                <ul style="padding-right: 20px;">
                    <?php foreach($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <?php if(!$success): ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="fullname">نام و نام خانوادگی:</label>
                <input type="text" id="fullname" name="fullname" 
                       value="<?php echo isset($user_data['fullname']) ? htmlspecialchars($user_data['fullname']) : ''; ?>" 
                       required>
            </div>
            
            <div class="form-group">
                <label for="email">ایمیل:</label>
                <input type="email" id="email" name="email" 
                       value="<?php echo isset($user_data['email']) ? htmlspecialchars($user_data['email']) : ''; ?>" 
                       required>
            </div>
            
            <div class="form-group">
                <label for="password">رمز عبور (حداقل 6 کاراکتر):</label>
                <input type="password" id="password" name="password" required minlength="6">
            </div>
            
            <div class="form-group">
                <label for="repeat_password">تکرار رمز عبور:</label>
                <input type="password" id="repeat_password" name="repeat_password" required>
            </div>
            
            <button type="submit" class="btn">ثبت نام</button>
        </form>
        
        <div class="link-text">
            <p>قبلا ثبت نام کرده‌اید؟ <a href="login-user.php">وارد شوید</a></p>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>