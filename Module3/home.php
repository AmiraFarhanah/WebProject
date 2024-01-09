<?php
    session_start();
    include("../config.php");
    if(!isset($_SESSION['id'])){
        header("Location: ../login.php");
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Registered User</title>
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>
    <div class="hero">
        <nav>
            <a href="home.php" class="logo"></a>
            
          
        
            
            <ul>
                <li><a href="/WebProject/Module3/home.php">Home</a></li>
                <li><a href="/WebProject/Module3/Orderlist.php">Orderlist</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
            <img src="/WebProject/Module1/login.png" class="user-pic" onclick="toggleMenu()">

            <div class="sub-menu-wrap" id="subMenu">
                <div class="sub-menu">

                
                    <div class="user-info">
                        <img src="/WebProject/Module1/login.png" style="margin-right: 10px;">
                        <?php
                        $id=$_SESSION['id'];
                        
                        
                        $res_name=null;
                        $query= mysqli_query($con, "SELECT * FROM registered_user where ID='$id'");
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

                    $id=$_SESSION['id'];
                    $query= mysqli_query($con, "SELECT * FROM registered_user where ID='$id'");

                    $res_id=null;
                    while($result= mysqli_fetch_assoc($query)){
                        $res_name=$result['Name'];
                        $res_username=$result['Username'];
                        $res_password=$result['Password'];
                        $res_address=$result['Address'];
                        $res_phonenumber=$result['Phonenumber'];
                        $res_id=$result['ID'];
                    }

                   

                   
                     echo "<a href='/WebProject/Module1/edit.php?Id=$res_id' class='sub-menu-link'>
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
        
        $query = mysqli_query($con, "SELECT * FROM menu WHERE FoodStatus = 1");
        
        echo '<div class="menu-container">';
        echo '<h2>Menu</h2>';
        
        while ($row = mysqli_fetch_assoc($query)) {
            echo '<div class="food-item">';
            echo '<div class="item-container">';
            echo '<div class="image-container">';
            
            $foodImageFilePath = $row['FoodImage'];
            echo '<img src="\WebProject\Module2\\' . $foodImageFilePath . '" alt="Food Image">';
            
            echo '</div>';
            echo '<h3>' . $row['Foodname'] . '</h3>';
            echo '<p class="description">' . $row['FoodDescription'] . '</p>';
            echo '<p class="quantity">Available Set: ' . $row['FoodQuantity'] . '</p>';
            echo '<p class="price">RM ' . $row['FoodPrice'] . '</p>';
            
            echo '<button class="card__order-button" onclick="orderFood()">Order</button>';
            
            echo '</div>';
            echo '</div>';
        }
        
        echo '</div>';
    ?>
    
    <script>
        let subMenu = document.getElementById("subMenu");

        function toggleMenu() {
            subMenu.classList.toggle("open-menu");
        }
    </script>

</body>
</html>
