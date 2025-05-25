<?php
session_start();
require_once 'dbh.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $user_id = $_SESSION['user_id'] ?? ''; // Use the logged-in user's ID
    
    if ($new_password !== $confirm_password) {
        echo "<script>alert('Passwords do not match'); window.history.back();</script>";
        exit();
    }

    // Fetch the current password hash from the database
    $query = "SELECT Password FROM Users WHERE UserID = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        echo "<script>alert('User not found'); window.location.href = '../login.php';</script>";
        exit();
    }

    $current_password_hash = $result['Password'];

    // Check if the new password is the same as the current password
    if (password_verify($new_password, $current_password_hash)) {
        echo "<script>alert('New password cannot be the same as the old password'); window.history.back();</script>";
        exit();
    }

    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update the password in the database
    $update = "UPDATE Users SET Password = :password WHERE UserID = :user_id";
    $stmt = $pdo->prepare($update);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    echo "<script>alert('Password has been reset successfully'); window.location.href = '../main.php';</script>";
}
?>
