<?php
session_start();
include("../config.php");
include 'phpqrcode/qrlib.php';

if (!isset($_SESSION['id'])) {
    header("Location: /WebProject/Module1/login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Food Vendor</title>
    <link rel="stylesheet" href="\WebProject\Module2\homeofvendor.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>

<body>
    <div class="hero">
        <nav>
            <a href="/WebProject/Module2/homefoodvendor.php" class="/WebProject/Module1/logo"></a>
            <ul>
            <li>
                <a href="homefoodvendor.php">Home</a></li>
                <li><a href="Dailymenu.php">Daily Menu</a></li>
                <li><a href="Orderlist.php">Order List</a></li>
                <li><a href="Dashboard.php">Dashboard</a></li>
            </ul>
            <img src="/WebProject/Module1/login.png" class="user-pic" onclick="toggleMenu()">
            <div class="sub-menu-wrap" id="subMenu">
                <div class="sub-menu">
                    <div class="user-info">
                        <img src="/WebProject/Module1/login.png" style="margin-right: 10px;">
                        <?php
                        $id = $_SESSION['id'];
                        $res_name = null;
                        $query = mysqli_query($con, "SELECT * FROM food_vendor where ID='$id'");
                        if (!$query) {
                            die("Query failed: " . mysqli_error($con));
                        }
                        if ($result = mysqli_fetch_assoc($query)) {
                            $res_name = $result['Name'];
                            echo "<h3>$res_name</h3>";
                        } else {
                            echo "<h3>No Name Found</h3>"; 
                        }
                        ?>
                    </div>
                    <hr>
                    <div>
                        <?php
                        $id = $_SESSION['id'];
                        $query = mysqli_query($con, "SELECT * FROM food_vendor where ID='$id'");
                        $res_id = null;
                        while ($result = mysqli_fetch_assoc($query)) {
                            $res_name = $result['Name'];
                            $res_username = $result['Username'];
                            $res_password = $result['Password'];
                            $res_address = $result['Address'];
                            $res_phonenumber = $result['Phonenumber'];
                            $res_email = $result['Email'];
                            $res_id = $result['ID'];
                        }

                        echo "<a href='/WebProject/Module1/editvendor.php?Id=$res_id' class='sub-menu-link'>
                            <img src='/WebProject/Module1/icon/edit.png' >
                            <p>Edit Profile</p>
                            <span>></span>
                        </a>";

                        echo "<a href='/WebProject/Module1/logout.php' class='sub-menu-link'>
                            <img src='/WebProject/Module1/icon/logout.png' >
                            <p>Log Out</p>
                            <span>></span>
                        </a>";
                        ?>
                    </div>
                </div>
            </div>
        </nav>
    </div>

    <?php
        $servername = "localhost";
        $username = "root";
        $password = ""; 
        $dbname = "project";
        
        $con = mysqli_connect($servername, $username, $password, $dbname);
        
        if (!$con) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
        $query = mysqli_prepare($con, "SELECT * FROM menu WHERE vendor_ID=?");

if ($query) {
    mysqli_stmt_bind_param($query, "i", $vendorID); // Assuming vendor_ID is an integer, adjust accordingly
    $vendorID = $_SESSION['id'];
    mysqli_stmt_execute($query);
    $result = mysqli_stmt_get_result($query);

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="card">';
        echo '<div class="card__body">';
        $foodImageFilePath = $row['FoodImage'];
        $imagePath = "\WebProject\Module2\\" . $foodImageFilePath;
        $imageWidth = 150; // Set your desired width
        $imageHeight = 150; // Set your desired height
        echo '<div class="card__body-cover-image foodimage">';
        echo '<img src="\WebProject\Module2\\' . $foodImageFilePath . '" alt="Food Image">';
        echo '</div>';
        echo '<h3 class="card__body-header-title">' . $row['Foodname'] . '</h3>';
        echo '<p class="card__body-quantity">Available Set: ' . $row['FoodQuantity'] . '</p>';
        echo '<form method="post" action="update_food_status.php">';
        echo '<input type="hidden" name="menuID" value="' . $row['ID'] . '">';
        echo '<label for="quantity">Quantity:</label>';
        echo '<input type="number" name="quantity" value="' . $row['FoodQuantity'] . '">';
        echo '<label for="availability">Availability:</label>';
        echo '<select name="availability">';
        echo '<option value="1" ' . ($row['FoodStatus'] == 1 ? 'selected' : '') . '>Available</option>';
        echo '<option value="0" ' . ($row['FoodStatus'] == 0 ? 'selected' : '') . '>Not Available</option>';
        echo '</select>';
        echo '<button type="submit" class="card__body-order-button">Update</button>';
        echo '</form>';

        echo '</div>';
        echo '</div>';
    }

    mysqli_stmt_close($query);
} else {
    die("Query preparation failed: " . mysqli_error($con));
}

    ?>


    <script>
        let subMenu = document.getElementById("subMenu");

        function toggleMenu() {
            subMenu.classList.toggle("open-menu");
        }
    </script>

</body>

</html>