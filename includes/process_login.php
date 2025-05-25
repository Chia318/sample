<?php
session_start();
include "dbh.inc.php"; // This defines $pdo

$email = $_POST['email'];
$password = $_POST['password'];
$recaptchaResponse = $_POST['g-recaptcha-response'];

// 1. Verify reCAPTCHA
$secretKey = '6Le8QUYrAAAAAAs6MOKJqsonhY5kDW5zRSfRuyCl';
$verifyUrl = "https://www.google.com/recaptcha/api/siteverify";
$response = file_get_contents($verifyUrl . "?secret=" . $secretKey . "&response=" . $recaptchaResponse . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
$responseKeys = json_decode($response, true);

if (!$responseKeys["success"]) {
    // reCAPTCHA failed
    header("Location: ../login.php?error=captcha");
    exit();
}

// 2. If CAPTCHA is valid, continue login
try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($password, $user['Password'])) {
            $_SESSION['user_id'] = $user['UserID'];
            $_SESSION['email'] = $user['Email'];
            $_SESSION['name'] = $user['Name'];
            $_SESSION['role'] = $user['RoleID'];

            header("Location: ../main.php");
            exit();
        } else {
            header("Location: ../login.php?error=wrongpassword");
            exit();
        }
    } else {
        header("Location: ../login.php?error=emailnotfound");
        exit();
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
