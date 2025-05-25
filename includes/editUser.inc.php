<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["UserID"];
	$name = $_POST["Name"];
	$email = $_POST["Email"];
	$role = $_POST["Role"];



    try {
        require_once "dbh.inc.php";

        $query = "UPDATE users SET Name = :Name, Email = :Email, RoleID = :RoleID WHERE UserID = :UserID;";

        $stmt = $pdo->prepare($query);

        $stmt->bindParam(":UserID", $id);
        $stmt->bindParam(":Name", $name);
        $stmt->bindParam(":Email", $email);
        $stmt->bindParam(":RoleID", $role); 

        $stmt->execute();

        $pdo = null;
        $stmt = null;

        header("Location: ../userManagement.php");
        die();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../userManagement.php");
}
?>
