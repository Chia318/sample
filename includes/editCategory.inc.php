<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve values from POST request safely
    $CategoryID = isset($_POST["CategoryID"]) ? $_POST["CategoryID"] : null;
    $CategoryName = isset($_POST["CategoryName"]) ? trim($_POST["CategoryName"]) : null;    
      

    // Validate required fields before proceeding
    if ($CategoryID === null || $CategoryName === "") {
        die("Error: Missing required fields.");
    }

    try {
        require_once "dbh.inc.php";

        // echo "<pre>";
        // var_dump($_POST);
        // echo "</pre>";
        // exit;

        // Prepare the SQL statement
        $query = "UPDATE category SET CategoryID = :CategoryID, CategoryName = :CategoryName WHERE CategoryID = :CategoryID;";
        
        $stmt = $pdo->prepare($query);

        // Bind parameters safely
        $stmt->bindParam(":CategoryID", $CategoryID,PDO::PARAM_STR);
        $stmt->bindParam(":CategoryName", $CategoryName, PDO::PARAM_STR);
        

        // var_dump($stmt);
        // exit;

        // Execute the query and verify success
        if ($stmt->execute()) {
            echo "Update successful!";
            header("Location: ../categoryInventory.php");
        } else {
            echo "Update failed!";
        }
        exit;

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../categoryInventory.php");
    exit;
}