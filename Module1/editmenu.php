<?php
session_start();
include("config.php");

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
}

// Add any necessary database connection code if not already included in 'config.php'

if (isset($_GET['id'])) {
    $menuId = $_GET['id'];

    // Fetch the menu item details from the database using the $menuId
    $query = mysqli_query($con, "SELECT * FROM menu WHERE ID='$menuId'");
    $menuDetails = mysqli_fetch_assoc($query);
} else {
    // Handle the case where 'id' is not set in the URL
    // Redirect or display an error message as needed
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home admin</title>
    <link rel="stylesheet" href="editmenu.css">
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
    
    <form action="update_menu.php" method="post">
        <input type="hidden" name="menu_id" value="<?php echo $menuDetails['ID']; ?>">

       
        <label for="food_name">Food Name:</label>
        <input type="text" id="food_name" name="food_name" value="<?php echo $menuDetails['Foodname']; ?>" required>

        <label for="food_description">Food Description:</label>
        <textarea id="food_description" name="food_description" required><?php echo $menuDetails['FoodDescription']; ?></textarea>

        <label for="FoodPrice">FoodPrice:</label>
        <textarea id="Food_Price" name="Food_Price" required><?php echo $menuDetails['FoodPrice']; ?></textarea>

        <label for="new_foodimage">New Food Image:</label>
        <input type="file" name="new_foodimage" id="new_foodimage" class="form-input" accept="image/*"><br>


        <input type="submit" value="Save Changes">
    </form>
</body>
</html>
