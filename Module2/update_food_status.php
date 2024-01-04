<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include("../config.php");

    $menuID = $_POST['ID'];
    $quantity = $_POST['quantity'];
    $availability = $_POST['availability'];

    $updateQuery = "UPDATE menu SET FoodQuantity = $quantity, FoodStatus = $availability WHERE ID = $menuID";
    $result = mysqli_query($con, $updateQuery);

    if (!$result) {
        die("Update failed: " . mysqli_error($con));
    }

    // Redirect back to the menu page after updating
    header("Location: /WebProject/Module2/Dailymenu.php");
    exit();
}
?>

