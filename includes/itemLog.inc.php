<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){
		$ItemID = $_POST["ItemID"];
		$ItemQty = isset($_POST["ItemQty"]) && $_POST["ItemQty"] !== '' ? $_POST["ItemQty"] : 0;
        $ItemStatus =$_POST["ItemStatus"];
		$CreatedDate = date("d/m/Y");

		try{
			require_once "dbh.inc.php";

			$query = "INSERT INTO itemlog (LogID, ItemID, ItemQty, ItemStatus, CreatedDate) VALUES (:LogID, :ItemID, :ItemQty, :ItemStatus, NOW());";

			$stmt = $pdo->prepare($query);

			$options = [
				'cost' => 12
			];
			$hashedPwd = password_hash("1234", PASSWORD_BCRYPT, $options);

            $stmt->bindParam(":LogID", $LogID);
            $stmt->bindParam(":ItemID" , $ItemID);
			$stmt->bindParam(":ItemQty" , $ItemQty);
            $stmt->bindParam(":ItemStatus" , $ItemStatus);
			

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