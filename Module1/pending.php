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
    <title>Bro Code</title>
    <link rel="stylesheet" href="style.css">
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

                $pendinglist = "SELECT * FROM food_vendor WHERE Status = 'Pending'";
                $result=mysqli_query($con, $pendinglist);

                
        //  Display the sorted data in a table
        echo "<style>
   
        .table-container {
            width: 50%;
            margin: 0;
            float: left; /* Adjusted to float right */
            margin-left: 350px; /* Adjusted margin-right to move it slightly to the right */
        }
    
        .styled-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 18px;
            text-align: left;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
        }
    
        .styled-table th, .styled-table td {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
        }
    
        .styled-table th {
            background-color: #2c3e50;
            font-weight: bold;
            color: #ecf0f1;
        }
    
        .styled-table tbody tr:hover {
            background-color: #f5f5f5;
        }
    
        .styled-button {
            background-color: #e74c3c; /* Red background color */
            color: #fff; /* White text color */
            padding: 10px 15px; /* Padding for the button */
            border: none; /* Remove the button border */
            border-radius: 5px; /* Add border-radius for rounded corners */
            cursor: pointer; /* Change cursor to pointer on hover */
            transition: background-color 0.3s; /* Add a smooth transition effect on hover */
        }
        
        .styled-button:hover {
            background-color: #c0392b; /* Darker red color on hover */
        }
    
    </style>";
    
                

                // Display the table
                echo "<div class='table-container'>
                <table class='styled-table'>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Approval Status</th>
                        <th>Action</th>
                    </tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['ID']}</td>
                        <td>{$row['Username']}</td>
                        <td>{$row['Email']}</td>
                        <td>{$row['Phonenumber']}</td>
                        <td>{$row['Status']}</td>
                        <td><button  class='styled-button' onclick='approveRow(". $row['ID'] .")'>Approve</button></td>
                    </tr>";
                }

                echo "</table>
                <div>"

    ?>

<script>
    function approveRow(id) {
            if (confirm("Are you sure you want to approve user this user?")){
                
                window.location.href = "changestatus.php?id=" + id ;
            }
        }

    let subMenu=document.getElementById("subMenu");

    function toggleMenu(){
        subMenu.classList.toggle("open-menu");
    }

</script>

</body>


</html>
