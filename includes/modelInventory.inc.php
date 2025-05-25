<?php

declare(strict_types=1);

require_once 'includes/dbh.inc.php';

function display_item()
{
    global $pdo;

    $query = "SELECT i.ItemID, i.ItemName, c.CategoryName, i.ItemQty 
              FROM item i
              JOIN category c on c.CategoryID=i.CategoryID;";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (isset($result)) {
        foreach ($result as $Item) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($Item['ItemID']) . "</td>";
            echo "<td>" . htmlspecialchars($Item['ItemName']) . "</td>";
            echo "<td>" . htmlspecialchars($Item["CategoryName"]) . "</td>";
            echo "<td>" . (int)$Item['ItemQty'] . "</td>";
            echo "<td>";
            echo "<button class=\"btn btn-sm btn-warning me-1 editItemBtn\" 
                    data-Item-id=\"" . htmlspecialchars($Item['ItemID']) . "\"
                    data-Item-name=\"" . htmlspecialchars($Item['ItemName']) . "\"
                    data-Item-category=\"" . htmlspecialchars($Item['CategoryName']) . "\"
                    data-Item-qty=\"" . (int)$Item['ItemQty'] . "\"
                    data-bs-toggle=\"modal\" 
                    data-bs-target=\"editInventoryModal\">
                    <i class=\"bx bx-edit\"></i>
                  </button>";
            echo "<button class=\"btn btn-sm btn-danger\" 
                    onclick=\"deleteItem('" . htmlspecialchars($Item['ItemID']) . "')\">
                    <i class=\"bx bx-trash\"></i>
                  </button>";
            echo "</td>";
            echo "</tr>";
        }
    }
}
