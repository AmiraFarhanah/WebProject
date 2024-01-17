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
    
    $servername = "localhost";
    $username = "root";
    $password = ""; 
    $dbname = "project";

    try {
        
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $id = $_SESSION['id'];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['edit'])) {
                header("Location: editmenu.php?ID=" . $_POST['ID']);
                exit();
            } elseif (isset($_POST['delete'])) {
                $menuIDToDelete = $_POST['ID'];
                $deleteSql = "DELETE FROM menu WHERE ID = :menuID";
                $stmt = $conn->prepare($deleteSql);
                $stmt->bindParam(':menuID', $menuIDToDelete, PDO::PARAM_STR);
                $stmt->execute();
                header("Location: {$_SERVER['PHP_SELF']}");
                exit();
            } elseif (isset($_POST['add'])) {
                $vendor_ID = isset($_POST['vendor_id']) ? $_POST['vendor_id'] : null;
                $foodname = isset($_POST['foodname']) ? $_POST['foodname'] : null;
                $foodquantity = isset($_POST['foodquantity']) ? $_POST['foodquantity'] : null;
                $fooddescription = isset($_POST['fooddescription']) ? $_POST['fooddescription'] : null;
                $foodstatus = isset($_POST['foodstatus']) ? $_POST['foodstatus'] : null;
                $foodprice = isset($_POST['FoodPrice']) ? $_POST['FoodPrice'] : null;

                if (isset($_FILES['foodimage']) && $_FILES['foodimage']['error'] === UPLOAD_ERR_OK) {
                    $tempFilePath = $_FILES['foodimage']['tmp_name'];
                    $foodImageFilePath = "/WebProject/Module2/uploads/" . $_FILES['foodimage']['name'];
                    move_uploaded_file($tempFilePath, $foodImageFilePath);
                } else {
                    // Handle the case where no file is uploaded or an error occurs during upload
                    echo '<p>Failed to upload food image.</p>';
                }
    
                // Use Google Charts API to generate QR code
    $qrCodePath = "\WebProject\Module2\uploads\qrcodes\. id().png";
    $googleChartsApiUrl = "https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=" . urlencode($foodname);
    file_put_contents($qrCodePath, file_get_contents($googleChartsApiUrl));

    $insertSql = "INSERT INTO menu (Foodname, FoodDescription, FoodImage, FoodPrice, Qrcode, vendor_ID) 
                    VALUES (:foodname, :fooddescription, :foodImage, :FoodPrice, :Qrcode, :vendor_ID)";

    $stmt = $conn->prepare($insertSql);
    $stmt->bindParam(':vendor_ID', $vendor_ID, PDO::PARAM_INT);
    $stmt->bindParam(':foodname', $foodname, PDO::PARAM_STR);
    $stmt->bindParam(':fooddescription', $fooddescription, PDO::PARAM_STR);
    $stmt->bindParam(':FoodPrice', $foodprice, PDO::PARAM_STR);
    $stmt->bindParam(':foodImage', $foodImageFilePath, PDO::PARAM_STR);
    $stmt->bindParam(':Qrcode', $qrCodePath, PDO::PARAM_STR);

    $stmt->execute();

    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
} else {
    echo '<p>Failed to upload image.</p>';
}
            
        }

        $id = $_SESSION['id'];
        $selectSql = "SELECT `menu`.*,food_vendor.Username
        FROM `menu`
        INNER JOIN food_vendor ON `menu`.`vendor_ID` = food_vendor.ID
        WHERE `menu`.vendor_ID =:id";
        
        $stmt = $conn->prepare($selectSql); // Initialize $stmt here
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        

        if (empty($result)) {
            echo '<table class="table">';
            echo '<tr class="header"><th>Foodname</th><th>FoodDescription</th>';
            echo '<th>FoodImage</th><th>FoodPrice</th><th>QR Code</th>';
            echo '<th>Actions</th></tr>';
            echo '<tr><td colspan="16">No menu items found.</td></tr>';
        } else {
            // Output menu 
            echo '<table class="table">';
            echo '<tr class="header"><th>Foodname</th><th>FoodDescription</th>';
            echo '<th>FoodPrice</th><th>QR Code</th><th>Food Image</th>';
            echo '<th>Actions</th></tr>';

            foreach ($result as $row) {
                echo '<tr class="row">';
                echo '<td class="cell">' . $row['Foodname'] . '</td>';
                echo '<td class="cell">' . $row['FoodDescription'] . '</td>';
                echo '<td class="cell">' . $row['FoodPrice'] . '</td>';
                echo '<td class="cell"><img src="' . $row['Qrcode'] . '" alt="QR Code" style="max-width: 100px; max-height: 100px;"></td>';
                echo '<td class="cell"><img src="' . $row['FoodImage'] . '" alt="Food Image" style="max-width: 100px; max-height: 100px;"></td>';
                echo '<td class="buttonClass">';
                echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">';
                echo '<input type="hidden" name="ID" value="' . $row['ID'] . '">';
                echo '<input type="submit" name="edit" value="Edit" class="buttonClass">';
                echo '<input type="submit" name="delete" value="Delete" class="buttonClass">';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }

            echo '</table>';
        }
        
        echo '<table class="form-table-container">';
        echo '<hr>';
        echo '<h2 style="text-align: center;font-weight: bold ;font-size: 30px;">Add New Menu Item</h2>';
        echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '" enctype="multipart/form-data" class="form-table">';
        echo '<tr><td>Foodname:</td><td><input type="text" name="foodname" required></td></tr>';
        echo '<tr><td>FoodDescription:</td><td><textarea name="fooddescription" required></textarea></td></tr>';
        echo '<tr><td>FoodPrice:</td><td><input type="text" name="FoodPrice" required></td></tr>';
        echo '<tr><td>FoodImage:</td><td><input type="file" name="foodimage" accept="image/*"></td></tr>';
        echo '<tr><td><input type="hidden" name="vendor_id" value="' . $id . '"></td></tr>';
        echo '<tr><td colspan="2" style="text-align: center;"><input type="submit" name="add" value="Add Menu"></td></tr>';
        echo '</form>';
        echo '</table>';
        

    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    // Close the connection
    $conn = null;
    ?>

    <script>
        let subMenu = document.getElementById("subMenu");

        function toggleMenu() {
            subMenu.classList.toggle("open-menu");
        }
    </script>

</body>

</html>
