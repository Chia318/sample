<?php
require_once 'dbh.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $roleID = $_POST['RoleID'];
    $roleName = $_POST['RoleName'];
    $permissions = $_POST['permissions'] ?? [];

    try {
        // Update role name
        $stmt = $pdo->prepare("UPDATE role SET RoleName = ? WHERE RoleID = ?");
        $stmt->execute([$roleName, $roleID]);

        // Delete old permissions
        $pdo->prepare("DELETE FROM role_permission WHERE RoleID = ?")->execute([$roleID]);

        // Insert new permissions
        $stmtPerm = $pdo->prepare("INSERT INTO role_permission (RoleID, PermissionID) VALUES (?, ?)");
        foreach ($permissions as $permID) {
            $stmtPerm->execute([$roleID, $permID]);
        }

        header("Location: ../roleManagement.php?edit=success");
        exit();
    } catch (PDOException $e) {
        die("Error editing role: " . $e->getMessage());
    }
}
