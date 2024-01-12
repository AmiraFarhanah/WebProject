

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
    <title>User List</title>
  


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
   
   
   $queryAdmin = "SELECT ID, Username, Name, Email, Usergroup, Qrcode FROM administrator";
   $resultAdmin = mysqli_query($con, $queryAdmin);
   
   $queryVendor = "SELECT ID, Username, Name, Email, Usergroup, Qrcode FROM food_vendor";
   $resultVendor = mysqli_query($con, $queryVendor);
   
   
   $queryRegisteredUser = "SELECT ID, Username, Name, Email, Usergroup, Qrcode FROM registered_user";
   $resultRegisteredUser = mysqli_query($con, $queryRegisteredUser);
  
        // Merge and sort the data based on ID
        $data = array();

        while ($row = $resultAdmin->fetch_assoc()) {
            $data[] = $row;
        }

        while ($row = $resultVendor->fetch_assoc()) {
            $data[] = $row;
        }

        while ($row = $resultRegisteredUser->fetch_assoc()) {
            $data[] = $row;
        }

        usort($data, function ($a, $b) {
            return $a['ID'] - $b['ID'];
        });

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

    
    echo "<div class='table-container'>
    <table class='styled-table'>
        <tr>
            
            <th>Username</th>
            <th>Name</th>
            <th>Email</th>
            <th>User group</th>
            <th>Qrcode</th>
            <th>Action</th> <!-- New column for delete button -->
        </tr>";

foreach ($data as $row) {
    echo "<tr>
            
            <td>" . $row['Username'] . "</td>
            <td>" . $row['Name'] . "</td>
            <td>" . $row['Email'] . "</td>
            <td>" . $row['Usergroup'] . "</td>
            <td>" . $row['Qrcode'] . "</td>
            <td><button  class='styled-button' style='margin-bottom: 5px;' onclick='deleteRow(\"" . $row['Username'] . "\", \"" . $row['Usergroup'] . "\")'>Delete</button>
            <br>            
            <button class='styled-button'  style='width: 100%;' onclick='editRow(\"" . $row['Username'] . "\", \"" . $row['Usergroup'] . "\" , \"" . $row['ID'] . "\")'>Edit</button></td>

            </tr>";
}

echo "</table>
</div>";

   
   ?>
<script>

    function editRow(username, usergroup, ID) {
            if (usergroup=="Food Vendor"){
                // Perform an AJAX request or redirect to a delete script
                // For simplicity, I'll redirect to a delete script with the ID as a parameter
                window.location.href = "admineditvendor.php?username=" + username + "&usergroup=" + usergroup+ "&ID=" + ID;
            }
            else if (usergroup=="Normal User"){
                // Perform an AJAX request or redirect to a delete script
                // For simplicity, I'll redirect to a delete script with the ID as a parameter
                window.location.href = "adminedituser.php?username=" + username + "&usergroup=" + usergroup+ "&ID=" + ID;
            }
            else if (usergroup=="Administrator"){
                // Perform an AJAX request or redirect to a delete script
                // For simplicity, I'll redirect to a delete script with the ID as a parameter
                window.location.href = "admineditadmin.php?username=" + username + "&usergroup=" + usergroup+ "&ID=" + ID;
            }
        }

    function deleteRow(username, usergroup) {
            if (confirm("Are you sure you want to delete user " + username + " with User group " + usergroup + "?")){
                // Perform an AJAX request or redirect to a delete script
                // For simplicity, I'll redirect to a delete script with the ID as a parameter
                window.location.href = "deleteuser.php?username=" + username + "&usergroup=" + usergroup;
            }
        }
    let subMenu=document.getElementById("subMenu");

    function toggleMenu(){
        subMenu.classList.toggle("open-menu");
    }

    

</script>

</body>


</html>
