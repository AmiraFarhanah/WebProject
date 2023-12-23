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
                <li><a href="#">Order List</a></li>
                <li><a href="#">Dashboard</a></li>
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
                            echo "<h3>No Name Found</h3>"; // or handle the case where the name is not found
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
    $password = ""; // If using the default root user with no password
    $dbname = "project";

    try {
        // Create a PDO connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
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
                // Handle adding a new menu item (insert into the database)
                $menuID = isset($_POST['menu_id']) ? $_POST['menu_id'] : null;
                $foodname = isset($_POST['foodname']) ? $_POST['foodname'] : null;
                $foodquantity = isset($_POST['foodquantity']) ? $_POST['foodquantity'] : null;
                $fooddescription = isset($_POST['fooddescription']) ? $_POST['fooddescription'] : null;
                $foodstatus = isset($_POST['foodstatus']) ? $_POST['foodstatus'] : null;
            
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
                    $uploadDir = 'uploads/';
                    $uploadFile = $uploadDir . basename($_FILES['foodimage']['name']);
            
                    if (!file_exists($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
            
                    $uploadFile = $uploadDir . basename($_FILES['foodimage']['name']);
            
                    if (move_uploaded_file($_FILES['foodimage']['tmp_name'], $uploadFile)) {
                        $foodImageFilePath = $uploadFile;
            
                        $sql = "INSERT INTO menu (Menu_ID, Foodname, FoodQuantity, FoodDescription, FoodStatus, Username, 
                                FoodImage, Sunday, Monday, Tuesday, Wednesday, Thursday, Friday, Saturday) 
                                VALUES (:menuID, :foodname, :foodquantity, :fooddescription, :foodstatus, :Username, 
                                :foodImage, :sunday, :monday, :tuesday, :wednesday, :thursday, :friday, :saturday)";
            
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':menuID', $menuID, PDO::PARAM_STR);
                        $stmt->bindParam(':foodname', $foodname, PDO::PARAM_STR);
                        $stmt->bindParam(':foodquantity', $foodquantity, PDO::PARAM_INT);
                        $stmt->bindParam(':fooddescription', $fooddescription, PDO::PARAM_STR);
                        $stmt->bindParam(':foodstatus', $foodstatus, PDO::PARAM_STR);
                        $stmt->bindParam(':Username', $res_username, PDO::PARAM_STR);
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
        $vendorID = $res_username;
        $sql = "SELECT * FROM menu WHERE Username = :Username";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':Username', $res_username, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Output the menu in an HTML table with edit and delete buttons
        echo '<table class="table">';
        echo '<tr class="header"><th>Menu_ID</th><th>Foodname</th><th>FoodQuantity</th><th>FoodDescription</th>';
        echo '<th>FoodStatus</th><th>Username</th><th>FoodImage</th><th>Sunday</th><th>Monday</th><th>Tuesday</th>';
        echo '<th>Wednesday</th><th>Thursday</th><th>Friday</th><th>Saturday</th><th>Actions</th></tr>';

        foreach ($result as $row) {
            echo '<tr class="row">';
            echo '<td class="cell">' . $row['Menu_ID'] . '</td>';
            echo '<td class="cell">' . $row['Foodname'] . '</td>';
            echo '<td class="cell">' . $row['FoodQuantity'] . '</td>';
            echo '<td class="cell">' . $row['FoodDescription'] . '</td>';
            echo '<td class="cell">' . $row['FoodStatus'] . '</td>';
            echo '<td class="cell">' . $row['Username'] . '</td>';
            echo '<td class="cell"><img src="' . $row['FoodImage'] . '" alt="Food Image" style="max-width: 100px; max-height: 100px;"></td>';
            echo '<td class="cell">' . ($row['Sunday'] ? 'yes' : '') . '</td>';
            echo '<td class="cell">' . ($row['Monday'] ? 'yes' : '') . '</td>';
            echo '<td class="cell">' . ($row['Tuesday'] ? 'yes' : '') . '</td>';
            echo '<td class="cell">' . ($row['Wednesday'] ? 'yes' : '') . '</td>';
            echo '<td class="cell">' . ($row['Thursday'] ? 'yes' : '') . '</td>';
            echo '<td class="cell">' . ($row['Friday'] ? 'yes' : '') . '</td>';
            echo '<td class="cell">' . ($row['Saturday'] ? 'yes' : '') . '</td>';
            echo '<td class="buttonClass">';
            echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">';
            echo '<input type="hidden" name="menu_id" value="' . $row['Menu_ID'] . '">';
            echo '<input type="submit" name="edit" value="Edit" class="buttonClass">';
            echo '<input type="submit" name="delete" value="Delete" class="buttonClass">';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }

        echo '</table>';
        echo '<table class="form-table-container">';
        echo '<h2 style="text-align: center;font-weight: bold ;font-size: 30px;">Add New Menu Item</h2>';
        echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '" enctype="multipart/form-data" class="form-table">';
        echo '<tr><td>Menu_ID:</td><td><input type="text" name="menu_id" required></td></tr>';
        echo '<tr><td>Foodname:</td><td><input type="text" name="foodname" required></td></tr>';
        echo '<tr><td>FoodQuantity:</td><td><input type="number" name="foodquantity" required></td></tr>';
        echo '<tr><td>FoodDescription:</td><td><textarea name="fooddescription" required></textarea></td></tr>';
        echo '<tr><td>FoodStatus:</td><td><input type="text" name="foodstatus" required></td></tr>';
        echo '<tr><td>FoodImage:</td><td><input type="file" name="foodimage" accept="image/*"></td></tr>';
        echo '<tr><td>Sunday:</td><td><input type="checkbox" name="sunday"></td></tr>';
        echo '<tr><td>Monday:</td><td><input type="checkbox" name="monday"></td></tr>';
        echo '<tr><td>Tuesday:</td><td><input type="checkbox" name="tuesday"></td></tr>';
        echo '<tr><td>Wednesday:</td><td><input type="checkbox" name="wednesday"></td></tr>';
        echo '<tr><td>Thursday:</td><td><input type="checkbox" name="thursday"></td></tr>';
        echo '<tr><td>Friday:</td><td><input type="checkbox" name="friday"></td></tr>';
        echo '<tr><td>Saturday:</td><td><input type="checkbox" name="saturday"></td></tr>';
        echo '<tr><td><input type="hidden" name="vendor_id" value="' . $vendorID . '"></td></tr>';
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