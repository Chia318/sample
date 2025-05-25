<?php
require_once 'dbh.inc.php';

$roleID = $_GET['roleID'] ?? 0;

// Get all permissions
$allStmt = $pdo->query("SELECT PermissionID, PermissionName FROM permission");
$allPermissions = $allStmt->fetchAll(PDO::FETCH_ASSOC);

// Get permissions for this role
$permStmt = $pdo->prepare("SELECT PermissionID FROM role_permission WHERE RoleID = ?");
$permStmt->execute([$roleID]);
$rolePermissions = $permStmt->fetchAll(PDO::FETCH_COLUMN);

echo json_encode([
    "allPermissions" => $allPermissions,
    "rolePermissions" => $rolePermissions
]);
