<?php
// شروع سشن
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// تخریب سشن
session_destroy();

// هدایت به صفحه اصلی
header("Location: ../index.php");
exit();
?>