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

                    echo "<a href='register.php' class='sub-menu-link'>
                        <img src='./icon/adduser.png' >
                        <p>Register User</p>
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

ini_set('display_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "project";

try {

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);


    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    function isAdministrator() {

        return true; 
    }

    if (isAdministrator()) {
        $sql = "SELECT * FROM menu";
        $stmt = $conn->prepare($sql);
    } else {
        $vendorID = $res_username;
        $sql = "SELECT * FROM menu WHERE Username = :Username";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':Username', $res_username, PDO::PARAM_STR);
    }

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

   
    echo '<table class="table">'; 
    echo '<tr class="header">'; 
    echo '<th>Foodname</th><th>FoodDescription</th><th>Username</th>';
    echo '<th>FoodPrice</th><th>Food Image</th><th>QRCode</th><th>Actions</th></tr>';

if ($stmt->rowCount() > 0) {
    foreach ($result as $row) {
        echo '<tr class="row">'; // Add the "row" class to each data row
        echo '<td class="cell">' . $row['Foodname'] . '</td>';
        echo '<td class="cell">' . $row['FoodDescription'] . '</td>';
        echo '<td class="cell">' . $row['Username'] . '</td>';
        echo '<td class="cell">' . $row['FoodPrice'] . '</td>';
        $foodImageFilePath = $row['FoodImage'];
        echo '<td class="cell"><img src="\WebProject\Module2\\' . $row['FoodImage'] . '" alt="Food Image" style="max-width: 100px; max-height: 100px;"></td>';
        $qrCodePath = $row['Qrcode'];
        echo '<td class="cell"><img src="\WebProject\Module2\\' . $row['Qrcode'] . '" alt="Qr Code" style="max-width: 100px; max-height: 100px;"></td>';
        echo '<td class="cell">
        <button onclick="editMenu(\'' . $row['ID'] . '\')">Edit</button>
        <button onclick="deleteMenu(\'' . $row['ID'] . '\')">Delete</button></td>';
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

    function editMenu(id) {
    window.location.href = '/WebProject/Module1/editmenu.php?id=' + id;
    }
</script>


</script>

</body>


</html>
