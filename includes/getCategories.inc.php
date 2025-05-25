<?php
require_once 'dbh.inc.php';

$query = "SELECT CategoryID,CategoryName FROM category ORDER BY CategoryName ASC";
$stmt = $pdo->prepare($query);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($categories as $category) {
    echo "<option value='{$category['CategoryID']}'>{$category['CategoryName']}</option>";
}