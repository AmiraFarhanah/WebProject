<?php
    session_start();
    include("config.php");
    if(!isset($_SESSION['valid'])){
        header("Location: /project/module 1/login.php");
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>instore selling</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>
    <div class="hero">
        <nav>
            <a href="home.php" class="logo"></a>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">FoodVendor</a></li>
                <li><a href="MEMBERSHIP.php">Membership Card</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
            <img src="login.png" class="user-pic" onclick="toggleMenu()">

            <div class="sub-menu-wrap" id="subMenu">
                <div class="sub-menu">

                
                    <div class="user-info">
                        <img src="login.png" style="margin-right: 10px;">
                        <h3>Information</h3> 


                    </div>
                    <hr>
                    <div>
                    <?php

                    $id=$_SESSION['valid'];
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

                   
                     echo "<a href='edit.php?Id=$res_id' class='sub-menu-link'>
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

  

    <h1 class="centered-heading">In-Store Selling </h1>
    <div class="container1">
             <table>
                <thead>
                    <th>Food Picture</th>
                    <th>Price</th>
                    <th>Menu ID</th>
                    <th>Vendor ID</th>
                    <th>Quantity</th>
                    <th colspan="3">Action</th>
                    <th>Payment</th>
                </thead>
                    <!--Sample only, still cannot connect to database huhu-->
                <tbody>
                    <tr>
                        <td><img src="meegureng.jpg" width="100" height="100" ></td>
                        <td>RM3.00</td>
                        <td>MN0131</td>
                        <td>FV22001</td>
                        <td>1</td>
                        <td><button type="submit" name="view" class="green-button">View</button></td>
                        <td><button type="submit" name="update" class="green-button">Update</button></td>
                        <td><button type="submit" name="cancel" class="red-button">Cancel</button></td>
                        <td><select>
                            <option value="cash">Cash</option>
                            <option value="online">Online payment</option>
                        </select></td>
                        
                    </tr>

                    <tr>
                        <td><img src="oden.jpg" width="100" height="100" ></td>
                        <td>RM5.00</td>
                        <td>MN0120</td>
                        <td>FV23002</td>
                        <td>1</td>
                        <td><button type="submit" name="view" class="green-button">View</button></td>
                        <td><button type="submit" name="update" class="green-button">Update</button></td>
                        <td><button type="submit" name="cancel" class="red-button">Cancel</button></td>
                        <td><select>
                            <option value="cash">Cash</option>
                            <option value="online">Online payment</option>
                        </select></td>
                    </tr>

                    <tr>
                        <td><img src="cikmak.jpg" width="100" height="100" ></td>
                        <td>RM2.00</td>
                        <td>MN0110</td>
                        <td>FV23001</td>
                        <td>1</td>
                        <td><button type="submit" name="view" class="green-button">View</button></td>
                        <td><button type="submit" name="update" class="green-button">Update</button></td>
                        <td><button type="submit" name="cancel" class="red-button">Cancel</button></td>
                        <td><select>
                            <option value="cash">Cash</option>
                            <option value="online">Online payment</option>
                        </select></td>
                    </tr>

                    <tr>
                        <td><img src="NasiGoreng.jpg" width="100" height="100" ></td>
                        <td>RM3.00</td>
                        <td>MN0130</td>
                        <td>FV24001</td>
                        <td>1</td>
                        <td><button type="submit" name="view" class="green-button">View</button></td>
                        <td><button type="submit" name="update" class="green-button">Update</button></td>
                        <td><button type="submit" name="cancel" class="red-button">Cancel</button></td>
                        <td><select>
                            <option value="cash">Cash</option>
                            <option value="online">Online payment</option>
                        </select></td>
                    </tr>

                </tbody>
            </table>
               
    </div>
    <button class="green-button" onclick="goback()">Back</button>  
    
    <form method="post" action="VIEW.php">
        <button type="submit" name="add" class="green-button" >Add</button>  
    </form>
    
    
    

<script>
    let subMenu=document.getElementById("subMenu");

    function toggleMenu(){
        subMenu.classList.toggle("open-menu");
    }

    function goback(){
        window.history.back();
    }

</script>

</body>


</html>
