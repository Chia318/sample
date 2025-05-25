<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){
		$ItemID = $_POST["ItemID"];
	    $ItemName = $_POST["ItemName"];
		$ItemQty = isset($_POST["ItemQty"]) && $_POST["ItemQty"] !== '' ? $_POST["ItemQty"] : 0;
		$CategoryID = $_POST["CategoryID"];

		try{
			require_once "dbh.inc.php";

			$query = "INSERT INTO Item (ItemID, ItemName, ItemQty, CategoryID) VALUES (:ItemID, :ItemName, :ItemQty, :CategoryID);";

			$stmt = $pdo->prepare($query);

			$options = [
				'cost' => 12
			];
			$hashedPwd = password_hash("1234", PASSWORD_BCRYPT, $options);

			$stmt->bindParam(":ItemID" , $ItemID);
			$stmt->bindParam(":ItemName" , $ItemName);
			$stmt->bindParam(":ItemQty" , $ItemQty);
			$stmt->bindParam(":CategoryID" , $CategoryID);

			$stmt ->execute();

			$pdo = null;
			$stmt = null;

			// Redirect to the new file after successful update
			// You can change the URL to the desired page
			header("Location: ../inventory.php");

			die();
		}catch(PDOException $e){
			die("Query failed: " . $e->getMessage());
		}
	}
	else{
		header("Location: ../inventory.php");
	}