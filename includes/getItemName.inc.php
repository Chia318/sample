<?php
require_once 'dbh.inc.php';

$query = "SELECT ItemID,ItemName FROM item ORDER BY ItemName ASC";
$stmt = $pdo->prepare($query);
$stmt->execute();
$Item = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($Item as $Item) {
    echo "<option value='{$Item['ItemID']}'>{$Item['ItemName']}</option>";
}