<?php
include('../config.php');


    $servername = "localhost";
    $username = "root";
    $password = ""; 
    $dbname = "project";

$connection = mysqli_connect($host, $username, $password, $database);

if (!$connection) {
    $error_message = "Connection failed: " . mysqli_connect_error();
    error_log($error_message);
    die($error_message);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data if set
    $foodName = isset($_POST['food_name']) ? $_POST['food_name'] : '';
    $foodDescription = isset($_POST['food_description']) ? $_POST['food_description'] : '';
    $foodQuantity = isset($_POST['food_quantity']) ? $_POST['food_quantity'] : 0;
    $foodStatus = isset($_POST['food_status']) ? $_POST['food_status'] : '';
    $username = isset($_POST['username']) ? $_POST['username'] : '';

    // Insert the new menu entry into the database
    $query = "INSERT INTO menu (Foodname, FoodDescription, FoodQuantity, FoodStatus, Username) 
              VALUES ('$foodName', '$foodDescription', $foodQuantity, '$foodStatus', '$username')";

    $result = mysqli_query($connection, $query);

    // Check if the query was successful
    if ($result) {
        echo "Menu added successfully!";
    } else {
        echo "Error: " . mysqli_error($connection);
    }
}

// Close the database connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Menu</title>
</head>
<body>
    <h2>Add New Menu</h2>
    <form method="post" action="add_menu.php">
        <label for="food_name">Food Name:</label>
        <input type="text" name="food_name" required><br>

        <label for="food_description">Food Description:</label>
        <textarea name="food_description" required></textarea><br>

        <label for="food_quantity">Food Quantity:</label>
        <input type="number" name="food_quantity" required><br>

        <label for="food_status">Food Status:</label>
        <input type="text" name="food_status" required><br>

        <label for="username">Username:</label>
        <input type="text" name="username" required><br>

        <input type="submit" value="Add Menu">
    </form>
</body>
</html>
