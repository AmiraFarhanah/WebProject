<?php
session_start();
include("../config.php");

// Check if the user is not logged in
if (!isset($_SESSION['valid'])) {
    header("Location: ../login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bro Code</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>
    <div class="hero">
        <nav>
            <a href="/Webproject/Module2/homefoodvendor.php" class="logo"></a>
            
            <ul>
                <li><a href="/Webproject/Module2/homefoodvendor.php">All Menu</a></li>
                <li><a href="/Webproject/Module2/DailyMenu.php">Daily Menu</a></li>
                <li><a href="#">OrderList</a></li>
                <li><a href="#">Dashboard</a></li>
            </ul>
            <img src="/Webproject/Module1/login.png" class="user-pic" onclick="toggleMenu()">

<div class="sub-menu-wrap" id="subMenu">
    <div class="sub-menu">

    
        <div class="user-info">
            <img src="/Webproject/Module1/login.png" style="margin-right: 10px;">
            <?php
            $id=$_SESSION['id'];
            
            
            $res_name=null;
            $query= mysqli_query($con, "SELECT * FROM food_vendor where ID='$id'");
            if (!$query) {
                die("Query failed: " . mysqli_error($con));
            }
        
            // Check if there are any results
            if ($result = mysqli_fetch_assoc($query)) {
                $res_name = $result['Name'];
                echo "<h3>$res_name</h3>";
            } else {
                echo "<h3>No Name Found</h3>"; // or handle the case where the name is not found
            }
            
        
?>
        </div>
        <hr>
        <div>
        <?php

        $id=$_SESSION['id'];
        $query= mysqli_query($con, "SELECT * FROM food_vendor where ID='$id'");

        $res_id=null;
        while($result= mysqli_fetch_assoc($query)){
            $res_name=$result['Name'];
            $res_username=$result['Username'];
            $res_password=$result['Password'];
            $res_address=$result['Address'];
            $res_phonenumber=$result['Phonenumber'];
            $res_email=$result['Email'];
            $res_id=$result['ID'];
        }

        
       
         echo "<a href='editvendor.php?Id=$res_id' class='sub-menu-link'>
        <img src='./icon/edit.png' >
        <p>Edit Profile</p>
        <span>></span>
        </a>";



        

        echo "<a href='logout.php' class='sub-menu-link'>
            <img src='./icon/logout.png' >
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
    $password = ""; // If using the default root user with no password
    $dbname = "project";

    try {
        // Create a PDO connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if the form is submitted for editing or adding a menu item
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['edit'])) {
                // Redirect to editmenu.php for editing
                header("Location: editmenu.php?menu_id=" . $_POST['menu_id']);
                exit();
            } elseif (isset($_POST['delete'])) {
                // Handle deleting menu item (delete from the database)
                $menuIDToDelete = $_POST['menu_id'];
                $sql = "DELETE FROM menu WHERE Menu_ID = :menuID";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':menuID', $menuIDToDelete, PDO::PARAM_STR);
                $stmt->execute();

                // Redirect to refresh the page after deletion
                header("Location: {$_SERVER['PHP_SELF']}");
                exit();
            } elseif (isset($_POST['add'])) {
                // Handle adding new menu item (insert into the database)
                $menuID = $_POST['menu_id'];
                $foodname = $_POST['foodname'];
                $foodquantity = $_POST['foodquantity'];
                $fooddescription = $_POST['fooddescription'];
                $foodstatus = $_POST['foodstatus'];
                $vendorID = $_POST['vendor_id'];

                // Process checkboxes for each day
                $sunday = isset($_POST['sunday']) ? 1 : 0;
                $monday = isset($_POST['monday']) ? 1 : 0;
                $tuesday = isset($_POST['tuesday']) ? 1 : 0;
                $wednesday = isset($_POST['wednesday']) ? 1 : 0;
                $thursday = isset($_POST['thursday']) ? 1 : 0;
                $friday = isset($_POST['friday']) ? 1 : 0;
                $saturday = isset($_POST['saturday']) ? 1 : 0;

                // Handle file upload
                if (isset($_FILES['foodimage']) && $_FILES['foodimage']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = 'uploads/'; // Specify the directory where you want to store the uploaded images
                    $uploadFile = $uploadDir . basename($_FILES['foodimage']['name']);

                    // Create the upload directory if it doesn't exist
                    if (!file_exists($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }

                    $uploadFile = $uploadDir . basename($_FILES['foodimage']['name']);

                    if (move_uploaded_file($_FILES['foodimage']['tmp_name'], $uploadFile)) {
                        // File successfully uploaded, now you can store the file path in the database
                        $foodImageFilePath = $uploadFile;

                        // Insert data into the database
                        $sql = "INSERT INTO menu (Menu_ID, Foodname, FoodQuantity, FoodDescription, FoodStatus, Vendor_ID, 
                                FoodImage, Sunday, Monday, Tuesday, Wednesday, Thursday, Friday, Saturday) 
                                VALUES (:menuID, :foodname, :foodquantity, :fooddescription, :foodstatus, :vendorID, 
                                :foodImage, :sunday, :monday, :tuesday, :wednesday, :thursday, :friday, :saturday)";
                        
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':menuID', $menuID, PDO::PARAM_STR);
                        $stmt->bindParam(':foodname', $foodname, PDO::PARAM_STR);
                        $stmt->bindParam(':foodquantity', $foodquantity, PDO::PARAM_INT);
                        $stmt->bindParam(':fooddescription', $fooddescription, PDO::PARAM_STR);
                        $stmt->bindParam(':foodstatus', $foodstatus, PDO::PARAM_STR);
                        $stmt->bindParam(':vendorID', $vendorID, PDO::PARAM_STR);
                        $stmt->bindParam(':foodImage', $foodImageFilePath, PDO::PARAM_STR);
                        $stmt->bindParam(':sunday', $sunday, PDO::PARAM_INT);
                        $stmt->bindParam(':monday', $monday, PDO::PARAM_INT);
                        $stmt->bindParam(':tuesday', $tuesday, PDO::PARAM_INT);
                        $stmt->bindParam(':wednesday', $wednesday, PDO::PARAM_INT);
                        $stmt->bindParam(':thursday', $thursday, PDO::PARAM_INT);
                        $stmt->bindParam(':friday', $friday, PDO::PARAM_INT);
                        $stmt->bindParam(':saturday', $saturday, PDO::PARAM_INT);

                        $stmt->execute();

                        // Redirect to refresh the page after addition
                        header("Location: {$_SERVER['PHP_SELF']}");
                        exit();
                    } else {
                        echo '<p>Failed to upload image.</p>';
                    }
                }
            }
        }

        // Fetch the menu items for display
$vendorID = $_POST['vendor_id'] ?? 'FV23001';
$sql = "SELECT * FROM menu WHERE Vendor_ID = :vendorID";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':vendorID', $vendorID, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Output the menu in an HTML table with edit and delete buttons
echo '<table border="1">';
echo '<tr><th>Menu_ID</th><th>Foodname</th><th>FoodQuantity</th><th>FoodDescription</th><th>FoodStatus</th><th>Vendor_ID</th><th>FoodImage</th>';
echo '<th>Sunday</th><th>Monday</th><th>Tuesday</th><th>Wednesday</th><th>Thursday</th><th>Friday</th><th>Saturday</th><th>Actions</th></tr>';

foreach ($result as $row) {
    echo '<tr>';
    echo '<td>' . $row['Menu_ID'] . '</td>';
    echo '<td>' . $row['Foodname'] . '</td>';
    echo '<td>' . $row['FoodQuantity'] . '</td>';
    echo '<td>' . $row['FoodDescription'] . '</td>';
    echo '<td>' . $row['FoodStatus'] . '</td>';
    echo '<td>' . $row['Vendor_ID'] . '</td>';

    // Display the FoodImage (assuming it's a file path)
    echo '<td><img src="' . $row['FoodImage'] . '" alt="Food Image" style="max-width: 100px; max-height: 100px;"></td>';

    // Display checkboxes for each day
    echo '<td>' . ($row['Sunday'] ? 'yes' : '') . '</td>';
    echo '<td>' . ($row['Monday'] ? 'yes' : '') . '</td>';
    echo '<td>' . ($row['Tuesday'] ? 'yes' : '') . '</td>';
    echo '<td>' . ($row['Wednesday'] ? 'yes' : '') . '</td>';
    echo '<td>' . ($row['Thursday'] ? 'yes' : '') . '</td>';
    echo '<td>' . ($row['Friday'] ? 'yes' : '') . '</td>';
    echo '<td>' . ($row['Saturday'] ? 'yes' : '') . '</td>';

    echo '<td>';
    echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">';
    echo '<input type="hidden" name="menu_id" value="' . $row['Menu_ID'] . '">';
    echo '<input type="submit" name="edit" value="Edit">';
    echo '<input type="submit" name="delete" value="Delete">';
    echo '</form>';
    echo '</td>';
    echo '</tr>';
}

echo '</table>';

        echo '<h2>Add New Menu Item</h2>';
        echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '" enctype="multipart/form-data">';
        echo 'Menu_ID: <input type="text" name="menu_id" required><br>'; // Added Menu_ID input
        echo 'Foodname: <input type="text" name="foodname" required><br>';
        echo 'FoodQuantity: <input type="number" name="foodquantity" required><br>';
        echo 'FoodDescription: <textarea name="fooddescription" required></textarea><br>';
        echo 'FoodStatus: <input type="text" name="foodstatus" required><br>';

        // Add input for image upload
        echo 'FoodImage: <input type="file" name="foodimage" accept="image/*"><br>';

        // Add checkboxes for each day
        echo 'Sunday: <input type="checkbox" name="sunday"><br>';
        echo 'Monday: <input type="checkbox" name="monday"><br>';
        echo 'Tuesday: <input type="checkbox" name="tuesday"><br>';
        echo 'Wednesday: <input type="checkbox" name="wednesday"><br>';
        echo 'Thursday: <input type="checkbox" name="thursday"><br>';
        echo 'Friday: <input type="checkbox" name="friday"><br>';
        echo 'Saturday: <input type="checkbox" name="saturday"><br>';

        echo '<input type="hidden" name="vendor_id" value="' . $vendorID . '">';
        echo '<input type="submit" name="add" value="Add Menu">';
        echo '</form>';
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
