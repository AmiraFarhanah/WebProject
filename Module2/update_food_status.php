<?php
session_start();
include("../config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $foodID = mysqli_real_escape_string($con, $_POST['menuID']);
    $quantity = mysqli_real_escape_string($con, $_POST['quantity']);
    $availability = mysqli_real_escape_string($con, $_POST['availability']);

    $updateQuery = "UPDATE menu SET FoodQuantity = ?, FoodStatus = ? WHERE ID = ?";
    $stmt = mysqli_prepare($con, $updateQuery);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "iii", $quantity, $availability, $foodID);
        $result = mysqli_stmt_execute($stmt);

        if (!$result) {
            die("Update failed: " . mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);

        header("Location: /WebProject/Module2/Dailymenu.php");
        exit();
    } else {
        die("Query preparation failed: " . mysqli_error($con));
    }
}
?>
