<?php
session_start();
include("config.php");

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Check if the Menu_ID parameter is set in the URL
if (isset($_GET['Menu_ID'])) {
    $menuID = $_GET['Menu_ID'];

    // Prepare and execute the delete query
    $deleteQuery = mysqli_query($con, "DELETE FROM menu WHERE Menu_ID = '$menuID'");
    
    // Check if the delete query was successful
    if ($deleteQuery) {
        header("Location: /WebProject/Module1/homeadmin.php");
    } else {
        echo "Error deleting menu item: " . mysqli_error($con);
    }
} else {
    echo "Invalid request. Menu_ID not specified.";
}
?>
