<?php
    session_start();
    include("config.php");
    
    
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>Pie Chart in Php</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <script type="text/javascript">
            <?php
            echo "var counts = [";
            echo "['User Type', 'Count'],";
            
            $queryAdmin = "SELECT COUNT(*) as count FROM administrator";
            $resultAdmin = mysqli_query($con, $queryAdmin);
            $countAdmin = mysqli_fetch_assoc($resultAdmin)['count'];
            echo "['Administrator', $countAdmin],";
            
            $queryVendor = "SELECT COUNT(*) as count FROM food_vendor";
            $resultVendor = mysqli_query($con, $queryVendor);
            $countVendor = mysqli_fetch_assoc($resultVendor)['count'];
            echo "['Food Vendor', $countVendor],";
            
            $queryRegisteredUser = "SELECT COUNT(*) as count FROM registered_user";
            $resultRegisteredUser = mysqli_query($con, $queryRegisteredUser);
            $countRegisteredUser = mysqli_fetch_assoc($resultRegisteredUser)['count'];
            echo "['Registered User', $countRegisteredUser]";
            
            echo "];";
            ?>

   google.charts.load('current', {'packages':['corechart']});
   google.charts.setOnLoadCallback(drawChart);

   function drawChart() {
      var data = google.visualization.arrayToDataTable(counts);

      var options = {
         title: 'User Types Distribution'
      };

      var chart = new google.visualization.PieChart(document.getElementById('piechart'));

      chart.draw(data, options);
   }
</script>
</head>
<body>
    <div class="hero">
        <nav>
            <a href="home.php" class="logo"></a>
            
          
                    

            
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
                        $res_name=$result['Name'];
                        $res_username=$result['Username'];
                        $res_password=$result['Password'];
                        $res_address=$result['Address'];
                        $res_email=$result['Email'];
                        $res_phonenumber=$result['Phonenumber'];
                        $res_id=$result['ID'];
                        $res_usertype=$result['Usergroup'];
                        

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
    </body>
    <body class="bg-dark">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6 m-auto">
                        <div class="card mt-5">

                                <div class="card-header">
                                    <h3>User Types Distribution</h3>

                                </div>
                                <div class="card-body">
                                    <div id="piechart" style="width: 400px; height: 200px;"></div>

                                </div>
                                <div class="card-footer">


                                </div>

                        </div>


                    </div>


                </div>

            
            </div>

            
    </body>
<script>
    let subMenu=document.getElementById("subMenu");

    function toggleMenu(){
        subMenu.classList.toggle("open-menu");
    }

    

</script>




</html>

