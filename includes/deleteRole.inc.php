<?php
require_once 'dbh.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['RoleID'])) {
    $roleID = $_POST['RoleID'];

    try {
        // Check if any user has this role assigned
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE RoleID = ?");
        $stmt->execute([$roleID]);
        $userCount = $stmt->fetchColumn();

        if ($userCount > 0) {
            // Role is assigned to user(s), cannot delete
            echo "role_assigned";
            exit;
        }

        // Delete related permissions
        $pdo->prepare("DELETE FROM role_permission WHERE RoleID = ?")->execute([$roleID]);

        // Delete role
        $pdo->prepare("DELETE FROM role WHERE RoleID = ?")->execute([$roleID]);

        echo "success";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
