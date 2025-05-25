<?php

declare(strict_types=1);

require_once 'dbh.inc.php';

if (!isset($_POST['CategoryID'])) {
    echo "invalid";
    exit();}
    $CategoryID = $_POST['CategoryID'];
    // Check if CategoryID exists before deleting
$query = "SELECT COUNT(*) FROM category WHERE categoryID = :categoryID";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':categoryID', $CategoryID, PDO::PARAM_STR);
$stmt->execute();
$count = $stmt->fetchColumn();
if ($count == 0) {
    echo "ERROR: Category does not exist";
    exit();
}


    $query = "DELETE FROM category WHERE categoryID = :categoryID";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':categoryID', $CategoryID, PDO::PARAM_STR);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error" . implode(" | ", $stmt->errorInfo());
    }
