<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

include_once 'dbh.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if email exists in the database
    $query = "SELECT UserID FROM users WHERE email = :email;";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":email", $email);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $otpExpired = date("Y-m-d H:i:s", strtotime("+5 minutes"));

        $query = "UPDATE users SET OTP = :otp, OTPExpired = :otpExpired WHERE email = :email;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":otp", $otp);
        $stmt->bindParam(":otpExpired", $otpExpired);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';          
            $mail->SMTPAuth = true;                  
            $mail->Username = 'mmu2510a@gmail.com'; 
            $mail->Password = 'nviq yuwr qgxb dmou';      
            $mail->SMTPSecure = 'tls';                
            $mail->Port = 587;                        

            // Recipients
            $mail->setFrom('mmu2510a@gmail.com', 'BakeryAid System');
            $mail->addAddress($email); // Add a recipient 

            // Content
            $mail->isHTML(true); 
            $mail->Subject = 'Your Password Reset OTP';
            $mail->Body    = 'Your OTP code is: <strong>' . $otp . '</strong>
                <br>This code will expire in 5 minutes.';

            $mail->send();
            echo 'Email has been sent.';
        } catch (Exception $e) {
            echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Email not found!";
        exit;
    }
} else {
    echo "Invalid request method.";
    exit;
}