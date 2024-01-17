<?php
session_start();
include("../config.php");

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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="Dashboard/dashboard.js"></script>
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
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

// Establish a connection to the database
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// SQL query for total OrderQuantity
$sqlTotalQuantity = "SELECT `order`.`Menu_ID`, menu.Foodname, 
                         SUM(`order`.`OrderQuantity`) as total_quantity
                  FROM `order`
                  INNER JOIN menu ON `order`.`Menu_ID` = menu.ID
                  WHERE `order`.`vendor_ID` = ?
                  GROUP BY `order`.`Menu_ID`";

// Prepare and execute the query
try {
    $stmtTotalQuantity = $pdo->prepare($sqlTotalQuantity);

    // Bind the vendor ID to the placeholder
    $vendorId = $_SESSION['id'];
    $stmtTotalQuantity->bindParam(1, $vendorId, PDO::PARAM_INT);

    // Execute the query
    $stmtTotalQuantity->execute();

    // Fetch the results
    $resultTotalQuantity = $stmtTotalQuantity->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<?php

$sqlTotalSales = "SELECT `order`.`Menu_ID`, menu.Foodname, 
                      SUM(`order`.`OrderQuantity`) as quantity_sold,
                      SUM(`order`.`OrderQuantity` * menu.FoodPrice) as total_sales 
               FROM `order`
               INNER JOIN menu ON `order`.`Menu_ID` = menu.ID
               WHERE `order`.`vendor_ID` = ?
               GROUP BY `order`.`Menu_ID`";

try {
    $stmtTotalSales = $pdo->prepare($sqlTotalSales);

    $vendorId = $_SESSION['id'];
    $stmtTotalSales->bindParam(1, $vendorId, PDO::PARAM_INT);

 
    $stmtTotalSales->execute();

    $resultTotalSales = $stmtTotalSales->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<?php

$labelsTotalSales = [];
$dataTotalSales = [];

foreach ($resultTotalSales as $row) {
    $labelsTotalSales[] = $row['Foodname'];
    $dataTotalSales[] = $row['total_sales'];
}

$labelsTotalQuantity = [];
$dataTotalQuantity = [];

foreach ($resultTotalQuantity as $row) {
    $labelsTotalQuantity[] = $row['Foodname'];
    $dataTotalQuantity[] = $row['total_quantity'];
}
?>

<div>Total Sale </div>
<canvas id="myPieChartTotalSales" width="300" height="300"></canvas>
<div>Total Sale of Food Quantity </div>
<canvas id="myPieChartTotalQuantity" width="300" height="300"></canvas>


<script>
 
var ctxTotalSales = document.getElementById('myPieChartTotalSales').getContext('2d');
var myPieChartTotalSales = new Chart(ctxTotalSales, {
    type: 'pie',
    data: {
        labels: <?php echo json_encode($labelsTotalSales); ?>,
        datasets: [{
            data: <?php echo json_encode($dataTotalSales); ?>,
            backgroundColor: [
                'rgba(255, 99, 132, 0.7)',
                'rgba(54, 162, 235, 0.7)',
                'rgba(255, 206, 86, 0.7)',
                'rgba(75, 192, 192, 0.7)',
                'rgba(153, 102, 255, 0.7)',
                'rgba(255, 159, 64, 0.7)',
            ],
        }],
    },
    options: {
        responsive: false, 
        maintainAspectRatio: false,
    }
});
</script>
<script>
    
var ctxTotalQuantity = document.getElementById('myPieChartTotalQuantity').getContext('2d');
var myPieChartTotalQuantity = new Chart(ctxTotalQuantity, {
    type: 'pie',
    data: {
        labels: <?php echo json_encode($labelsTotalQuantity); ?>,
        datasets: [{
            data: <?php echo json_encode($dataTotalQuantity); ?>,
            backgroundColor: [
                'rgba(255, 99, 132, 0.7)',
                'rgba(54, 162, 235, 0.7)',
                'rgba(255, 206, 86, 0.7)',
                'rgba(75, 192, 192, 0.7)',
                'rgba(153, 102, 255, 0.7)',
                'rgba(255, 159, 64, 0.7)',
            ],
        }],
    },
    options: {
        responsive: false, 
        maintainAspectRatio: false, 
    }
});
</script>

