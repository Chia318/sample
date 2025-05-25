<?php

declare(strict_types=1);

require_once 'includes/dbh.inc.php';

function display_category()
{
    global $pdo;

    $query = "SELECT CategoryID, CategoryName FROM category;";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (isset($result)) {
        foreach ($result as $Category) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($Category['CategoryID']) . "</td>";
            echo "<td>" . htmlspecialchars($Category['CategoryName']) . "</td>";
            echo "<td>";
            echo "<button class=\"btn btn-sm btn-warning me-1 editCategoryBtn\" 
                    data-category-id=\"" . htmlspecialchars($Category['CategoryID']) . "\"
                    data-Category-name=\"" . htmlspecialchars($Category['CategoryName']) . "\"
                    data-bs-toggle=\"modal\" 
                    data-bs-target=\"editCategoryModal\">
                    <i class=\"bx bx-edit\"></i>
                  </button>";
            echo "<button class=\"btn btn-sm btn-danger\" 
                    onclick=\"deleteCategory('" . htmlspecialchars($Category['CategoryID']) . "')\">
                    <i class=\"bx bx-trash\"></i>
                  </button>";
            echo "</td>";
            echo "</tr>";
        }
    }
}
