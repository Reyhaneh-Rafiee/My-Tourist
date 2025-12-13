<?php
session_start();

// پاک کردن session
session_unset();
session_destroy();

// حذف کوکی session
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// هدایت به صفحه اصلی
header("Location: ../login-form.html");
exit();
?>