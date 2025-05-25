<?php
require_once 'dbh.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $roleName = $_POST['RoleName'];
    $permissions = $_POST['permissions'] ?? [];

    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM role WHERE RoleName = ?");
        $stmt->execute([$roleName]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            header("Location: ../roleManagement.php?add=duplicate");
            exit();
        }

        // Start transaction
        $pdo->beginTransaction();

        // Insert new role (RoleID generated via trigger)
        $stmt = $pdo->prepare("INSERT INTO role (RoleName) VALUES (?)");
        $stmt->execute([$roleName]);

        // Get the generated RoleID by selecting latest entry with this RoleName
        $stmt = $pdo->prepare("SELECT RoleID FROM role WHERE RoleName = ? ORDER BY RoleID DESC LIMIT 1");
        $stmt->execute([$roleName]);
        $row = $stmt->fetch();

        if (!$row || !$row['RoleID']) {
            throw new Exception("Unable to retrieve RoleID.");
        }

        $roleID = $row['RoleID'];

        // Insert selected permissions into role_permission table
        $stmtPerm = $pdo->prepare("INSERT INTO role_permission (RoleID, PermissionID) VALUES (?, ?)");
        foreach ($permissions as $permID) {
            $stmtPerm->execute([$roleID, $permID]);
        }

        // Commit changes
        $pdo->commit();

        header("Location: ../roleManagement.php?add=success");
        exit();
    } catch (Exception $e) {
        // Rollback on error
        $pdo->rollBack();
        die("Error adding role: " . $e->getMessage());
    }
}
