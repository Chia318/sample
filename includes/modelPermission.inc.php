<?php

declare(strict_types=1);

function display_permission()
{
    require_once 'dbh.inc.php';
    global $pdo;

    $query = "SELECT * FROM permission;";

    $stmt = $pdo->prepare($query);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result) {
        foreach ($result as $row) {
            echo "<tr>
            <td>" . htmlspecialchars($row['PermissionID']) . "</td>
            <td>" . htmlspecialchars($row['PermissionName']) . "</td>
            </tr>";
        }
    }
}