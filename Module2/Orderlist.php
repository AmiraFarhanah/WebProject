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
    <link rel="stylesheet" href="\WebProject\Module2\orderlist.css">
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
    // Assuming you have a database connection established
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "project";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Function to update order status using prepared statement
    function updateOrderStatus($orderId, $newStatus)
    {
        global $conn;

        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("UPDATE `order` SET Orderstatus=? WHERE Order_ID=?");
        $stmt->bind_param("si", $newStatus, $orderId);
        $stmt->execute();
        $stmt->close();
    }

    // Set the parameter value
$id = $_SESSION['id'];

// Prepare and bind the statement with the parameter
$stmt = $conn->prepare("SELECT `order`.Order_ID, `order`.Orderdate, `order`.Ordertime, `order`.Orderstatus, menu.Foodname, menu.FoodImage, registered_user.Name 
FROM `order` 
INNER JOIN menu ON `order`.Menu_ID = menu.ID 
INNER JOIN registered_user ON `order`.Register_ID = registered_user.ID 
WHERE `order`.`vendor_ID` = ?;");
$stmt->bind_param("i", $id);


    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<table border='1'>
            <tr>
                <th>Order ID</th>
                <th>Order Date</th>
                <th>Order Time</th>
                <th>Order Status</th>
                <th>Name</th>
                <th>Foodname</th>
                <th>Action</th>
            </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['Order_ID']}</td>
                <td>{$row['Orderdate']}</td>
                <td>{$row['Ordertime']}</td>
                <td>{$row['Orderstatus']}</td>
                <td>{$row['Name']}</td>
                <td>{$row['Foodname']}</td>
                <td>
                    <form method='post'>
                        <input type='hidden' name='orderId' value='{$row['Order_ID']}' />
                        <select name='newStatus'>
                            <option value='prepared'>Prepared</option>
                            <option value='completed'>Completed</option>
                        </select>
                        <input type='submit' name='updateStatus' value='Update' />
                    </form>
                </td>
                </tr>";
        }

        echo "</table>";

        // Handle order status update
        if (isset($_POST['updateStatus'])) {
            $orderId = $_POST['orderId'];
            $newStatus = $_POST['newStatus'];
            updateOrderStatus($orderId, $newStatus);
            header("Location: orderlist.php"); // Redirect to refresh the page
            exit(); // Ensure no further code execution after redirection
        }
    } else {
        echo "0 results";
    }

    $stmt->close();
    $conn->close();
    ?>

    <!-- Add a refresh button -->
    <form method="post">
        <input type="submit" name="refreshButton" value="Refresh">
    </form>

    <script>
        let subMenu = document.getElementById("subMenu");

        function toggleMenu() {
            subMenu.classList.toggle("open-menu");
        }
    </script>

</body>
</html>

