<?php
    session_start();
    include("config.php");
    if(!isset($_SESSION['id'])){
        header("Location: login.php");
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home admin</title>
    <link rel="stylesheet" href="homeadmin.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>
    <div class="hero">
        <nav>
            <a href="homeadmin.php" class="logo"></a>
            
          
                    

            
            <ul>
                <li><a href="admindashboard.php">Dashboard</a></li>
                <li><a href="Userlist.php">User list</a></li>
                <li><a href="pending.php">Application pending list</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
            
            <img src="login.png" class="user-pic" onclick="toggleMenu()">

            <div class="sub-menu-wrap" id="subMenu">
                <div class="sub-menu">

                
                    <div class="user-info">
                        <img src="login.png" style="margin-right: 10px;">
                        <?php
                        $id=$_SESSION['id'];
                        
                        
                        $res_name=null;
                        $query= mysqli_query($con, "SELECT * FROM administrator where ID='$id'");
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
                        
                       
                        
                        <!-- $id=$_SESSION['valid'];
                        $nama= mysqli_query($con, "SELECT Name FROM administrator where ID='$id'");
                        echo "<h3>$nama</h3>";
                        -->

                    </div>
                    <hr>
                    <div>
                    <?php

                    $id=$_SESSION['id'];
                    $query= mysqli_query($con, "SELECT * FROM administrator where ID='$id'");

                    $res_id=null;
                    while($result= mysqli_fetch_assoc($query)){
                        $res_name=$result['Name'];
                        $res_username=$result['Username'];
                        $res_password=$result['Password'];
                        $res_address=$result['Address'];
                        $res_email=$result['Email'];
                        $res_phonenumber=$result['Phonenumber'];
                        $res_id=$result['ID'];
                        $res_usertype=$result['Usergroup'];
                        

                    }

                    

                   
                     echo "<a href='editadmin.php?Id=$res_id' class='sub-menu-link'>
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
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = ""; // If using the default root user with no password
$dbname = "project";

try {
    // Create a PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Function to check if the user is an administrator
    function isAdministrator() {
        // Replace this with your actual logic to check if the user is an administrator
        // For example, if you have a role system, check if the user has the 'administrator' role.
        return true; // Placeholder, replace with actual logic
    }

    // Fetch menu items based on user role
    if (isAdministrator()) {
        // Fetch all menu items for administrators
        $sql = "SELECT * FROM menu";
        $stmt = $conn->prepare($sql);
    } else {
        // Fetch only menu items for the current user
        $vendorID = $res_username;
        $sql = "SELECT * FROM menu WHERE Username = :Username";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':Username', $res_username, PDO::PARAM_STR);
    }

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output the menu in an HTML table with edit and delete buttons
    echo '<table class="table">'; // Add the "table" class to the table
    echo '<tr class="header">'; // Add the "header" class to the header row
    echo '<th>Foodname</th><th>FoodDescription</th><th>Username</th><th>Food Image</th>';
    echo '<th>QRCode</th><th>Actions</th></tr>';

    // Check if any rows were returned
    // Check if any rows were returned
if ($stmt->rowCount() > 0) {
    foreach ($result as $row) {
        echo '<tr class="row">'; // Add the "row" class to each data row
        echo '<td class="cell">' . $row['Foodname'] . '</td>';
        echo '<td class="cell">' . $row['FoodDescription'] . '</td>';
        
        echo '<td class="cell">' . $row['Username'] . '</td>';
        
        $foodImageFilePath = $row['FoodImage'];
        echo '<td class="cell"><img src="\WebProject\Module2\\' . $row['FoodImage'] . '" alt="Food Image" style="max-width: 100px; max-height: 100px;"></td>';
        
        $qrCodePath = $row['Qrcode'];
        echo '<td class="cell"><img src="\WebProject\Module2\\' . $row['Qrcode'] . '" alt="Qr Code" style="max-width: 100px; max-height: 100px;"></td>';
        echo '<td class="cell"><button onclick="deleteMenu(\''. $row['ID'] .'\')">Delete</button></td>';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
    }
   


} else {
    echo '<tr><td colspan="16">No menu items found.</td></tr>';
}


    echo '</table>';

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the connection
$conn = null;
?>
              


<script>
    let subMenu=document.getElementById("subMenu");

    function toggleMenu(){
        subMenu.classList.toggle("open-menu");
    }

    function deleteMenu(menuID) {
            if (confirm("Are you sure you want to delete this menu item?")) {
                window.location.href = 'delete_menu.php?ID=' + menuID;
            }
        }

</script>

</body>


</html>
