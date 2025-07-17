<?php
session_start();
$currentPage = basename($_SERVER['PHP_SELF']);

$publicPages = [
    'index.php','login.php','signup.php','infos.php',
    'forgotPass.php','checkToken.php','changePass.php'
];
$clientForbiden = [];
$doctorForbiden = [];

if (empty($_SESSION['id_user']) && !empty($_COOKIE['id_user'])) {
    $_SESSION['id_user'] = $_COOKIE['id_user'];
    $_SESSION['Uname'] = $_COOKIE['Uname'];
    $_SESSION['role'] = $_COOKIE['role'];
}

if (empty($_SESSION['id_user'])) {
    if (!in_array($currentPage, $publicPages)) {
        echo "<script>
            alert('Session expired, please relogin');
            window.location.href = 'login.php';
            </script>";
        exit;
    }
}
?>