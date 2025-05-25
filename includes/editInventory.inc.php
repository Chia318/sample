<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve values from POST request safely
    $ItemID = isset($_POST["InventoryID"]) ? $_POST["InventoryID"] : null;
    $ItemName = isset($_POST["InventoryName"]) ? trim($_POST["InventoryName"]) : null;    
    $ItemQty = isset($_POST["InventoryQuantity"]) && $_POST["InventoryQuantity"] !== '' 
             ? intval($_POST["InventoryQuantity"]) 
             : null;
    $CategoryID = isset($_POST["editCategoryID"]) ? $_POST["editCategoryID"] : null;

    

    // Validate required fields before proceeding
    if ($ItemID === null || $ItemName === "" || $CategoryID === null) {
        die("Error: Missing required fields.");
    }

    try {
        require_once "dbh.inc.php";

        // echo "<pre>";
        // var_dump($_POST);
        // echo "</pre>";
        // exit;

        // Prepare the SQL statement
        $query = "UPDATE Item SET ItemName = :ItemName, ItemQty = :ItemQty, CategoryID = :CategoryID WHERE ItemID = :ItemID;";
        
        $stmt = $pdo->prepare($query);

        // Bind parameters safely
        $stmt->bindParam(":ItemID", $ItemID, PDO::PARAM_STR);
        $stmt->bindParam(":ItemName", $ItemName, PDO::PARAM_STR);
        $stmt->bindParam(":ItemQty", $ItemQty, PDO::PARAM_INT);
        $stmt->bindParam(":CategoryID", $CategoryID,PDO::PARAM_STR);

        // var_dump($stmt);
        // exit;

        // Execute the query and verify success
        if ($stmt->execute()) {
            echo "Update successful!";
            header("Location: ../inventory.php");
        } else {
            echo "Update failed!";
        }
        exit;

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../inventory.php");
    exit;
}