<?php

declare(strict_types=1);

require_once 'dbh.inc.php';

if (isset($_POST['ItemID'])) {
    $ItemID = $_POST['ItemID'];

    $query = "DELETE FROM Item WHERE ItemID = :ItemID";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':ItemID', $ItemID, PDO::PARAM_STR);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "invalid";
}