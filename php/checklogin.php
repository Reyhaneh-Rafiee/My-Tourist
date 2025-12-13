<?php
session_start();
require('config.php');

function isLoggedIn() {
    return isset($_SESSION['user_type']);
}

function isUser() {
    return isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'user';
}

function isAdmin() {
    return isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'admin';
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: ../login-form.html");
        exit();
    }
}

function requireUser() {
    if (!isUser()) {
        header("Location: ../login-form.html");
        exit();
    }
}

function requireAdmin() {
    if (!isAdmin()) {
        header("Location: ../login-form.html");
        exit();
    }
}

// تابع برای جلوگیری از SQL Injection
function clean_input($data, $connect) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = mysqli_real_escape_string($connect, $data);
    return $data;
}
?>