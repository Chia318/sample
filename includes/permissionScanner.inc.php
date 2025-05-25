<?php
require_once 'includes/dbh.inc.php';
global $pdo;

$directory = dirname(__DIR__);
$permissionSet = [];

$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
foreach ($rii as $file) {
    if (!$file->isFile() || $file->getExtension() !== 'php') continue;

    $contents = file_get_contents($file->getPathname());

    if (preg_match_all('/\/\/\s*permission:\s*(.+)/i', $contents, $matches)) {
        foreach ($matches[1] as $permission) {
            $permissionSet[] = trim($permission);
        }
    }
}

$permissionSet = array_unique($permissionSet);

$stmt = $pdo->prepare("SELECT PermissionName FROM permission");
$stmt->execute();
$existing = $stmt->fetchAll(PDO::FETCH_COLUMN);

$newPermissions = array_diff($permissionSet, $existing);

if (!empty($newPermissions)) {
    $insertStmt = $pdo->prepare("INSERT INTO permission (PermissionName) VALUES (:name)");
    foreach ($newPermissions as $perm) {
        $insertStmt->execute([':name' => $perm]);
    }
    $message = count($newPermissions) . " new permissions added.";
} else {
    $message = "All permissions are already recorded.";
}

return $message;
