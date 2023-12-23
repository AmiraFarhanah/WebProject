<?php
session_start();
include("../config.php");

if (!isset($_SESSION['valid'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $foodname = mysqli_real_escape_string($con, $_POST["foodname"]);
    $foodquantity = mysqli_real_escape_string($con, $_POST["foodquantity"]);
    $fooddescription = mysqli_real_escape_string($con, $_POST["fooddescription"]);
    $foodstatus = mysqli_real_escape_string($con, $_POST["foodstatus"]);

    // Handle the selected days
    $selectedDays = isset($_POST["days"]) ? $_POST["days"] : array();

    // File upload handling
    $targetDirectory = "upload/";
    $targetFile = $targetDirectory . basename($_FILES["foodimage"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Construct the SQL query
    $insertQuery = "INSERT INTO menu (Foodname, FoodQuantity, FoodDescription, FoodStatus, FoodImage, Username, Sunday, Monday, Tuesday, Wednesday, Thursday, Friday, Saturday) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($con, $insertQuery);

    // Check if the statement was prepared successfully
    if ($stmt) {
        // Bind parameters
  // Bind parameters
mysqli_stmt_bind_param($stmt, 'sssssssssssss', $foodname, $foodquantity, $fooddescription, $foodstatus, $targetFile, $_SESSION['valid'], ...$selectedDays);


        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // Redirect with success message
            header("Location: /WebProject/Module2/homefoodvendor.php?success=1");
            exit();
        } else {
            // Redirect with error message
            header("Location: /WebProject/Module2/homefoodvendor.php?error=1");
            exit();
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Redirect with error message
        header("Location: /WebProject/Module2/homefoodvendor.php?error=1");
        exit();
    }
}
?>
