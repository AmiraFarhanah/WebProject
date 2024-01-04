<?php
session_start();
include("config.php");

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Check if the ID parameter is set in the URL
if (isset($_GET['ID'])) {
    $menuID = $_GET['ID'];

    // Disable foreign key checks
    $con->query('SET foreign_key_checks = 0');

    // Prepare and bind the delete query
    $deleteQuery = $con->prepare("DELETE FROM menu WHERE ID = ?");
    $deleteQuery->bind_param("s", $menuID);

    // Execute the delete query
    if ($deleteQuery->execute()) {
        header("Location: /WebProject/Module1/homeadmin.php");
    } else {
        echo "Error deleting menu item: " . $deleteQuery->error;
    }

    // Close the prepared statement
    $deleteQuery->close();

    // Enable foreign key checks
    $con->query('SET foreign_key_checks = 1');
} else {
    echo "Invalid request. ID not specified.";
}
?>
