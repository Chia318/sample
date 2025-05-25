<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){
		$name = $_POST["Name"];
		$email = $_POST["Email"];
		$role = $_POST["Role"];


		try{
			require_once "dbh.inc.php";

			$query = "INSERT INTO users (Name, Email, Password, RoleID) VALUES (:Name, :Email, :Password, :RoleID);";

			$stmt = $pdo->prepare($query);

			$options = [
				'cost' => 12
			];
			$hashedPwd = password_hash("1234", PASSWORD_BCRYPT, $options);

			$stmt->bindParam(":Name" , $name);
			$stmt->bindParam(":Email" , $email);
			$stmt->bindParam(":Password" , $hashedPwd);
			$stmt->bindParam(":RoleID" , $role);

			$stmt ->execute();

			$pdo = null;
			$stmt = null;

			header("Location: ../userManagement.php");

			die();
		}catch(PDOException $e){
			die("Query failed: " . $e->getMessage());
		}
	}
	else{
		header("Location: ../userManagement.php");
	}