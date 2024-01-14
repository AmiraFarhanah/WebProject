<?php
    session_start();
    include("config.php");
    if(!isset($_SESSION['valid'])){
        header("Location: login.php");
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bro Code</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>
    <div class="hero">
        <nav>
            <a href="homeadmin.php" class="logo"></a>
            
            <ul>
                <li><a href="homeadmin.php">Home</a></li>
                <li><a href="admindashboard.php">Dashboard</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
            <img src="login.png" class="user-pic" onclick="toggleMenu()">

            <div class="sub-menu-wrap" id="subMenu">
                <div class="sub-menu">

                
                    <div class="user-info">
                        <img src="login.png" style="margin-right: 10px;">
                        <h3>Hai Lat</h3> 


                    </div>
                    <hr>
                    <div>
                    <?php

                    $id=$_SESSION['valid'];
                    $query= mysqli_query($con, "SELECT * FROM administrator where ID='$id'");

                    $res_id=null;
                    while($result= mysqli_fetch_assoc($query)){
                        $res_name=$result['Administrator_Name'];
                        $res_username=$result['Administrator_Username'];
                        $res_password=$result['Administrator_Password'];
                        $res_address=$result['Administrator_Address'];
                        $res_email=$result['Administrator_EmailAddress'];
                        $res_phonenumber=$result['Administrator_PhoneNum'];
                        $res_id=$result['ID'];
                        $res_usertype=$result['Usertype'];
                        

                    }

                    echo "<a href='login.php' class='sub-menu-link'>
                        <img src='./icon/login.png'>
                        <p>Login</p>
                        <span>></span>

                    </a>";

                    


                    echo "<a href='register.php' class='sub-menu-link'>
                        <img src='./icon/signin.png' style='height: 40px; width: 40px;'>
                        <p>Sign In</p>
                        <span>></span>

                    </a>";

                   
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
<script>
    let subMenu=document.getElementById("subMenu");

    function toggleMenu(){
        subMenu.classList.toggle("open-menu");
    }

</script>

</body>


</html>
