<?php
session_start();
include("config.php");

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $menuId = $_POST['menu_id'];
    $foodName = mysqli_real_escape_string($con, $_POST['food_name']);
    $foodDescription = mysqli_real_escape_string($con, $_POST['food_description']);
    $FoodPrice = mysqli_real_escape_string($con, $_POST['Food_Price']);

    $updateQuery = "UPDATE menu SET Foodname='$foodName', FoodDescription='$foodDescription', FoodPrice='$FoodPrice'";

    $updateQuery .= " WHERE ID='$menuId'";
    
    $result = mysqli_query($con, $updateQuery);

    if ($result) {
        header("Location: homeadmin.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($con);
        exit();
    }
} else {
    // Handle non-POST requests if needed
    exit();
}
?>
