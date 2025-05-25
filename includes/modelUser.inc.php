<?php

declare(strict_types=1);

require_once 'dbh.inc.php';

function display_user()
{
    global $pdo;

    $query = "SELECT u.UserID, u.Name, u.Email, u.RoleID, r.RoleName 
              FROM users u
              JOIN role r ON u.RoleID = r.RoleID";

    $stmt = $pdo->prepare($query);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result) {
        foreach ($result as $member) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($member['UserID']) . "</td>";
            echo "<td>" . htmlspecialchars($member['Name']) . "</td>";
            echo "<td>" . htmlspecialchars($member['Email']) . "</td>";
            echo "<td>" . htmlspecialchars($member['RoleName']) . "</td>"; // Show role name
            echo "<td>";
            echo "<button class=\"btn btn-sm btn-warning me-1 editUserBtn\" 
                    data-user-id=\"" . htmlspecialchars($member['UserID']) . "\" 
                    data-user-name=\"" . htmlspecialchars($member['Name']) . "\" 
                    data-user-email=\"" . htmlspecialchars($member['Email']) . "\" 
                    data-user-role=\"" . htmlspecialchars($member['RoleID']) . "\" 
                    data-bs-toggle=\"modal\" 
                    data-bs-target=\"#editUserModal\">
                    <i class=\"bx bx-edit\"></i>
                  </button>";
            echo "<button class=\"btn btn-sm btn-danger\" 
                    onclick=\"deleteUser('" . htmlspecialchars($member['UserID']) . "')\">
                    <i class=\"bx bx-trash\"></i>
                  </button>";
            echo "</td>";
            echo "</tr>";
        }
    }
}

function fetch_roles() {
    global $pdo;
    $query = "SELECT RoleID, RoleName FROM role";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

