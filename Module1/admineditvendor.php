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
    <link rel="stylesheet" href="style.css">
    <title>Edit Profile</title>

</head>
<body>
    <div class="hero">
        <nav>
            <a href="homeadmin.php" class="logo"></a>
            
            <ul>
                <li><a href="admindashboard.php">Dashboard</a></li>
                <li><a href="Userlist.php">User list</a></li>
                <li><a href="#">About</a></li>
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
                    
                    <a href="editadmin.php" class="sub-menu-link">
                        <img src="./icon/edit.png"  >
                        <p>Edit Profile</p>
                        <span>></span>

                    </a>

                    <a href='register.php' class='sub-menu-link'>
                        <img src='./icon/adduser.png' >
                        <p>Register User</p>
                        <span>></span>

                    </a>

                    <a href="logout.php" class="sub-menu-link">
                        <img src="./icon/logout.png"  >
                        <p>Log Out</p>
                        <span>></span>

                    </a>
                    

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
<div class="container">
    <div class="kotak form-kotak">

        <?php
           
            if (isset($_GET['ID'])){
                $ID = $_GET['ID'];
            }

            if(isset($_POST['submit'])){
                $name=$_POST['name'];
                $username=$_POST['username'];
                $password=$_POST['password'];
                $address=$_POST['address'];
                $phonenumber=$_POST['phonenumber'];
                $email=$_POST['email'];
                $id=$_SESSION['id'];
                $image=$_POST['image'];

                
                $qrcode='<img src= "https://api.qrserver.com/v1/create-qr-code/?data='.$name. '&size=100x100">';

                $verify_query1=mysqli_query($con, "SELECT Username FROM food_vendor WHERE Username= '$username' AND ID!='$ID' ");
                
                if(mysqli_num_rows($verify_query1)!=0){
                    echo "<div class='message'>
                        <p>This username has been used, Try another one!</p>
                        </div><br>";

                    echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";

                }
                else{
                    if($image!=null){
                        
                        $edit_query = mysqli_query($con, "UPDATE food_vendor SET Name='$name', Username='$username', Password='$password', Address= '$address', Phonenumber='$phonenumber', Email='$email', Qrcode='$qrcode', Profilepicture='$image' WHERE ID=$ID") or die("error occurred");

                    }
                    else{
                        $edit_query = mysqli_query($con, "UPDATE food_vendor SET Name='$name', Username='$username', Password='$password', Address= '$address', Phonenumber='$phonenumber', Email='$email', Qrcode='$qrcode' WHERE ID=$ID") or die("error occurred");

                    }

                        if ($edit_query) {
                            header("Location: /WebProject/Module1/homeadmin.php");
                            exit();
                        } else {
                            echo "Error updating profile: " . mysqli_error($con);
                        }

                }
                

                

            }else{
                if (isset($_GET['username'])){
                    $username = $_GET['username'];
                    if (isset($_GET['usergroup'])){
                        $usergroup = $_GET['usergroup'];
                        if (isset($_GET['ID'])){
                            $ID = $_GET['ID'];
                        }
                        
                    }

                }
                if($usergroup=="Food Vendor"){
                
                   $selectQuery = "SELECT * FROM food_vendor WHERE Username = '$username'";
                   $query=mysqli_query($con, $selectQuery);
                

                while($result= mysqli_fetch_assoc($query)){
                    $res_name=$result['Name'];
                    $res_username=$result['Username'];
                    $res_password=$result['Password'];
                    $res_address=$result['Address'];
                    $res_phonenumber=$result['Phonenumber'];
                    $res_email=$result['Email'];
                    $res_image=$result['Profilepicture'];

                    
                }
            }
            
        ?>
        <header>Edit Profile</header>
        <?php
              if($res_image == null){
               ?>
                <div class="no-image">
                
                <p1> [No Image Available] </p1>

                <br>
                <br>

             <?php
              }
              else{
            ?>
            <div class="profilepic">
            <img src="./icon/<?php echo "$res_image"?>" width="100" height="80" >
            </div>
            <br>
            
            <?php
              }
            ?>
        <form action="" method="post">
            <div class="file-input-container">
                    <input type="file" name="image" id="image" class="file-input">
                    <span id=fileNameDisplay></span><br><br>
                    <label for="fileInput" class="file-label">Upload Photo</label>
                    </div>
            <div class="field input">
                <label for="Name">Name</label>
                <input type="text" name="name" id="name" value="<?php echo $res_name?>" placeholder="   Name.." required>
            </div>
            <div class="field input">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" value="<?php echo $res_username?>" placeholder="   Username.." required >
            </div>

            <div class="field input">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" value="<?php echo $res_password?>" placeholder="   Password.." required>
            </div>

            <div class="field input">
                <label for="address">Address</label>
                <input type="text" name="address" id="address"  value="<?php echo $res_address?>"placeholder="  Address.." required>
            </div>

            <div class="field input">
                <label for="phonenumber">Phone Number</label>
                <input type="text" name="phonenumber" id="phonenumber"  value="<?php echo $res_phonenumber?>" placeholder=" Phone number..." required>
            </div>

            <div class="field input">
                <label for="email">Email</label>
                <input type="text" name="email" id="email"  value="<?php echo $res_email?>" placeholder=" Email..." required>
            </div>


            <div class="field">
                <input type="submit" name="submit" class="btn" value="Save" required>
            </div>

            

        </form>

    </div>
    <?php }?>
</div>

</body>
</html>
