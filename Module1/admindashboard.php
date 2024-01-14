

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
         title: 'User Types Distribution',
                backgroundColor: {
                fill: '#fbe3e8', // Set your desired background color
                stroke: '#d9d9d9', // Set the border color if needed
                strokeWidth: 0 // Set the border width if needed
    }
         
         
      };

      var chart = new google.visualization.PieChart(document.getElementById('piechart'));

      chart.draw(data, options);
   }
</script>



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


    <div id="piechart" style="width: 900px; height: 500px;"></div>
<script>
    let subMenu=document.getElementById("subMenu");

    function toggleMenu(){
        subMenu.classList.toggle("open-menu");
    }

    

</script>

</body>


</html>
