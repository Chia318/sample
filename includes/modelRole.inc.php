<?php

declare(strict_types=1);

require_once 'dbh.inc.php';

function display_roles()
{
    global $pdo;

    $query = "SELECT RoleID, RoleName FROM role;";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (isset($result)) {
        foreach ($result as $role) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($role['RoleID']) . "</td>";
            echo "<td>" . htmlspecialchars($role['RoleName']) . "</td>";
            echo "<td>";
            echo "<button class=\"btn btn-sm btn-warning me-1 editRoleBtn\" 
                    data-role-id=\"" . htmlspecialchars($role['RoleID']) . "\"
                    data-role-name=\"" . htmlspecialchars($role['RoleName']) . "\"
                    data-bs-toggle=\"modal\" 
                    data-bs-target=\"#editRoleModal\">
                    <i class=\"bx bx-edit\"></i>
                  </button>";
            echo "<button class=\"btn btn-sm btn-danger\" 
                    onclick=\"deleteRole('" . htmlspecialchars($role['RoleID']) . "')\">
                    <i class=\"bx bx-trash\"></i>
                  </button>";
            echo "</td>";
            echo "</tr>";
        }
    }
}

function get_all_permissions()
{
    global $pdo;

    $query = "SELECT PermissionID, PermissionName FROM permission;";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
