<?php
session_start();
include("../config.php");

if (!isset($_SESSION['valid'])) {
    header("Location: ../login.php");
    exit();
}

$vendorID = $_SESSION['valid'];
$dayOfWeek = date("l"); // Get the current day
$menuQuery = mysqli_query($con, "SELECT Foodname FROM vendor_menu WHERE Vendor_ID='$vendorID' AND Menu_Day='$dayOfWeek'");
?>

<!DOCTYPE html>                                                                                                                                                                                                
<head>
    <!-- ... (head section) ... -->
</head>
<body>
    <h2>Today's Menu</h2>
    <ul>
        <?php
        while ($menuItem = mysqli_fetch_assoc($menuQuery)) {
            echo '<li>' . $menuItem['Foodname'] . '</li>';
        }
        ?>
    </ul>
</body>
</html>
