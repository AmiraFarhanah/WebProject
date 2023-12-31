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
                <li><a href="homefoodvendor.php">Home</a></li>
                <li><a href="Dailymenu.php">Daily Menu</a></li>
                <li><a href="Orderlist.php">Order List</a></li>
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


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve values from the form
    $menuId = $_POST["ID"];
    $foodQuantity = $_POST["food_quantity"];
    $availability = isset($_POST["availability"]) ? 1 : 0; // 1 for available, 0 for not available

    // Update the database with food availability
    $sql = "UPDATE menu SET FoodQuantity = ?, FoodStatus = ? WHERE ID = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error in SQL statement: " . $conn->error);
    }

    $stmt->bind_param("iii", $foodQuantity, $availability, $menuId);
    $stmt->execute();
    $stmt->close();
}

// Display all food names and pictures
$sql = "SELECT ID, Foodname, FoodImage, FoodQuantity, FoodStatus FROM menu WHERE Vendor_ID = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $menuId = $row["ID"];
        $foodname = $row["Foodname"];
        $foodImage = $row["FoodImage"];
        $foodQuantity = $row["FoodQuantity"];
        $foodStatus = $row["FoodStatus"];

        // Display food details
        echo "<div>";
        echo "<h2>$foodname</h2>";
        echo "<img src='$foodImage' alt='$foodname' style='max-width: 200px;'><br>";
        echo "<p>Quantity: $foodQuantity</p>";

        // Display availability checkbox for food vendor
        echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
        echo "<input type='hidden' name='ID' value='$menuId'>";
        echo "<label for='food_quantity'>Update Quantity:</label>";
        echo "<input type='number' name='food_quantity' value='$foodQuantity' required><br>";
        echo "<select name='availability'>";
        echo "<option value='1'" . ($foodStatus == 1 ? " selected" : "") . ">Available</option>";
        echo "<option value='0'" . ($foodStatus == 0 ? " selected" : "") . ">Not Available</option>";
        echo "</select><br>";
        echo "<input type='submit' value='Update'>";
        echo "</form>";

        echo "</div><hr>";
    }
} else {
    echo "No food items found.";
}

// Close the database connection
$conn->close();
?>


    <script>
        let subMenu = document.getElementById("subMenu");

        function toggleMenu() {
            subMenu.classList.toggle("open-menu");
        }
    </script>

</body>

</html>