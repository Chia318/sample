<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){
		$ItemID = $_POST["ItemID"];
		$ItemQty = isset($_POST["ItemQty"]) && $_POST["ItemQty"] !== '' ? $_POST["ItemQty"] : 0;
        $ItemStatus =$_POST["ItemStatus"];
		$CreatedDate = date("d/m/Y");

		try{
			require_once "dbh.inc.php";

			$checkQtyQuery = "SELECT ItemQty FROM Item WHERE ItemID = :ItemID";
        	$stmtCheck = $pdo->prepare($checkQtyQuery);
        	$stmtCheck->bindParam(":ItemID", $ItemID);
    	    $stmtCheck->execute();
	        $result = $stmtCheck->fetch(PDO::FETCH_ASSOC);

			if ($result && $result["ItemQty"] < $ItemQty) {
            //die("Error Message：Quantity exceeds available stock.");
				$_SESSION["error"] = "Insufficient stock. Please enter a valid quantity.";
            	header("Location: ../inventory.php");
				exit();
			}

			$query = "INSERT INTO itemlog (LogID, ItemID, ItemQty, ItemStatus, CreatedDate) VALUES (:LogID, :ItemID, :ItemQty, :ItemStatus, NOW());";
			$update = "UPDATE Item SET ItemQty=ItemQty-:ItemQty where ItemID=:ItemID;";

			$stmtInsert = $pdo->prepare($query);
			$stmtUpdate = $pdo->prepare($update);

			$options = [
				'cost' => 12
			];
			$hashedPwd = password_hash("1234", PASSWORD_BCRYPT, $options);

            $stmtInsert->bindParam(":LogID", $LogID);
            $stmtInsert->bindParam(":ItemID" , $ItemID);
			$stmtInsert->bindParam(":ItemQty" , $ItemQty);
            $stmtInsert->bindParam(":ItemStatus" , $ItemStatus);
			
			$stmtInsert ->execute();

			$stmtUpdate->bindParam(":ItemID" , $ItemID);
			$stmtUpdate->bindParam(":ItemQty" , $ItemQty);
		
			$stmtUpdate ->execute();

			$pdo = null;
			$stmtInsert = null;
			$stmtUpdate = null;

			$_SESSION["success"] = "Stock updated successfully.";
        	header("Location: ../inventory.php");
        	exit();
		

			
			// Redirect to the new file after successful update
			// You can change the URL to the desired page
			die();
		}catch(PDOException $e){
			die("Query failed: " . $e->getMessage());
		}
	}
	else{
		header("Location: ../inventory.php");
	}