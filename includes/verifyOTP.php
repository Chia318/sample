<?php
include_once 'dbh.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $otp = $_POST['otp'];

    $query = "SELECT OTP, OTPExpired FROM users WHERE email = :email;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if ($user['OTP'] == $otp) {
            $now = date("Y-m-d H:i:s");
            if ($now <= $user['OTPExpired']) {
                echo "OTP verified";
            } else {
                echo "OTP expired. Please request a new one.";
            }
        } else {
            echo "Invalid OTP.";
        }
    } else {
        echo "Email not found.";
    }
} else {
    echo "Invalid request method.";
}
