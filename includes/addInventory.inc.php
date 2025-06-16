<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){
		$ItemID = isset($_POST["ItemID"]) ? $_POST["ItemID"] : null;
	    $ItemName = $_POST["ItemName"];
		$ItemQty = isset($_POST["ItemQty"]) && $_POST["ItemQty"] !== '' ? $_POST["ItemQty"] : 0;
		$CategoryID = $_POST["CategoryID"];

		try{
			require_once "dbh.inc.php";

			$queryCheck = "SELECT ItemName, ItemQty FROM Item WHERE ItemName = :ItemName and CategoryID = :CategoryID";
			$stmtCheck = $pdo->prepare($queryCheck);
			$stmtCheck->bindParam(":ItemName", $ItemName, PDO::PARAM_STR);
			$stmtCheck->execute();
			$existingItem = $stmtCheck->fetch(PDO::FETCH_ASSOC);
			
			if($existingItem){
				//If Item already exists, update the quantity
				$newQty = $existingItem['ItemQty'] + $ItemQty;
				$queryUpdate = "UPDATE Item SET ItemQty = :newQty WHERE ItemName = :ItemName AND CategoryID = :CategoryID";
				$stmtUpdate = $pdo->prepare($queryUpdate);
				$stmtUpdate->bindParam(":newQty", $newQty, PDO::PARAM_INT);
				$stmtUpdate->bindParam(":ItemName", $existingItem['ItemName'], PDO::PARAM_STR);
				$stmtUpdate->execute();
			}
			// If Item does not exist, insert a new record
			else{
				$queryInsert = "INSERT INTO Item (ItemID, ItemName, ItemQty, CategoryID)
				VALUES (:ItemID, :ItemName, :ItemQty, :CategoryID);";
				$stmtInsert = $pdo->prepare($queryInsert);
				$stmtInsert->bindParam(":ItemID" , $ItemID);
				$stmtInsert->bindParam(":ItemName" , $ItemName);
				$stmtInsert->bindParam(":ItemQty" , $ItemQty);
				$stmtInsert->bindParam(":CategoryID" , $CategoryID);
				$stmtInsert->execute();
			}

			

			$options = [
				'cost' => 12
			];
			$hashedPwd = password_hash("1234", PASSWORD_BCRYPT, $options);

			$stmtCheck = null;
			$stmtUpdate = null;
			$stmtInsert = null;
			$pdo = null;

			// Redirect to the new file after successful update
			// You can change the URL to the desired page
			header("Location: ../inventory.php");
			exit();
		}catch(PDOException $e){
			die("Query failed: " . $e->getMessage());
		}
	}else{
		header("Location: ../inventory.php");
		exit();
	}
// End of includes/addInventory.inc.php
// This file handles the addition of inventory items to the database.