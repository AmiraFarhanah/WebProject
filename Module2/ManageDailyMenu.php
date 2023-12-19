<?php
session_start();
include("../config.php");

if (!isset($_SESSION['valid'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['setup_menu'])) {
    $vendorID = $_POST['vendor_id'];
    $menuDay = $_POST['menu_day'];
    $selectedMenuItems = $_POST['menu_items'];

    // Insert selected menu items into a new table (vendor_menu)
    foreach ($selectedMenuItems as $menuItem) {
        $sql = "INSERT INTO vendor_menu (Vendor_ID, Menu_Day, Foodname) VALUES ('$vendorID', '$menuDay', '$menuItem')";
        mysqli_query($con, $sql);
    }

    // Redirect or show a success message
    header("Location: DailyMenu.php"); // Change to the appropriate page
    exit();
}
?>
