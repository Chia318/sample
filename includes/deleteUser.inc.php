<?php

declare(strict_types=1);

require_once 'dbh.inc.php';

if (isset($_POST['UserID'])) {
    $userID = $_POST['UserID'];

    $query = "DELETE FROM users WHERE UserID = :userID";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "invalid";
}