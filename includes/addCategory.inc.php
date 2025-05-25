<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){
	    $CategoryName = $_POST["CategoryName"];

		try{
			require_once "dbh.inc.php";

			$query = "INSERT INTO Category (CategoryID, CategoryName) VALUES (:CategoryID, :CategoryName);";

			$stmt = $pdo->prepare($query);

			$options = [
				'cost' => 12
			];
			$hashedPwd = password_hash("1234", PASSWORD_BCRYPT, $options);

			$stmt->bindParam(":CategoryID" , $CategoryID);
			$stmt->bindParam(":CategoryName" , $CategoryName);

			$stmt ->execute();

			$pdo = null;
			$stmt = null;

			// Redirect to the new file after successful update
			// You can change the URL to the desired page
			header("Location: ../categoryInventory.php");

			die();
		}catch(PDOException $e){
			die("Query failed: " . $e->getMessage());
		}
	}
	else{
		header("Location: ../categoryInventory.php");
	}