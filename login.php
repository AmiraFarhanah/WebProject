<?php
    session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>

</head>
<body>
    <div class="container">
        <div class="kotak form-kotak">
            <?php
                include("config.php");
                if(isset($_POST["submit"])){
                    $username=mysqli_real_escape_string($con,$_POST['username']);
                    $password=mysqli_real_escape_string($con,$_POST['password']);
                    $usergroup=mysqli_real_escape_string($con,$_POST['usergroup']);

                    if($usergroup=="Normal User"){
                        $result=mysqli_query($con, "SELECT * FROM registered_user WHERE Username='$username' AND Usergroup='$usergroup' AND Password ='$password'")or die("Select Error");
                        $row=mysqli_fetch_assoc($result);
                        if(mysqli_num_rows($result)!=0){
                                $_SESSION['valid']= $row['Username'];
                                $_SESSION['name']= $row['Name'];
                                $_SESSION['password']= $row['Password'];
                                $_SESSION['address']= $row['Address'];
                                $_SESSION['email']=$row['Email'];
                                $_SESSION['phonenumber']= $row['Phonenumber'];
                                $_SESSION['usergroup']= $row['Usergroup'];
                                $_SESSION['id']=$row['ID'];

                                if(isset($_SESSION['valid'])){
                                    header("Location: home.php");
                                    exit();
                                
                                }


                        }   

                    
                        else{
                            echo "<div class='message'>
                            <p>Wrong Username or Password or User Group</p>
                            </div> <br>";
                            echo"<a href='login.php'><button class='btn'>Go Back</button>";

                        }
                        
                    }
                    else if ($usergroup=="Administrator"){
                        $result=mysqli_query($con, "SELECT * FROM administrator WHERE Administrator_Username='$username' AND Usergroup='$usergroup' AND Administrator_Password ='$password'")or die("Select Error");
                        $row=mysqli_fetch_assoc($result);
                        if(mysqli_num_rows($result)!=0){
                                $_SESSION['valid']= $row['Administrator_Username'];
                                $_SESSION['name']= $row['Administrator_Name'];
                                $_SESSION['password']= $row['Administrator_Password'];
                                $_SESSION['address']= $row['Administrator_Address'];
                                $_SESSION['phonenumber']= $row['Administrator_PhoneNum'];
                                $_SESSION['email']=$row['Administrator_EmailAddress'];
                                $_SESSION['usergroup']= $row['Usergroup'];
                                $_SESSION['id']=$row['ID'];

                                if(isset($_SESSION['valid'])){
                                    header("Location: homeadmin.php");
                                    exit();
                                
                                }

                       
                    

                        }

                    
                        else{
                            echo "<div class='message'>
                            <p>Wrong Username or Password or User Group</p>
                            </div> <br>";
                            echo"<a href='login.php'><button class='btn'>Go Back</button>";

                        }
                        
                    }

                    else if ($usergroup=="Food Vendor"){
                        $result=mysqli_query($con, "SELECT * FROM food_vendor WHERE Vendor_Username='$username' AND Usergroup='$usergroup' AND Vendor_Password ='$password'")or die("Select Error");
                        $row=mysqli_fetch_assoc($result);
                        if(mysqli_num_rows($result)!=0){
                                $_SESSION['valid']= $row['Vendor_Username'];
                                $_SESSION['name']= $row['Vendor_Name'];
                                $_SESSION['password']= $row['Vendor_Password'];
                                $_SESSION['address']= $row['Vendor_Address'];
                                $_SESSION['phonenumber']= $row['Vendor_PhoneNum'];
                                $_SESSION['email']=$row['Vendor_Email'];
                                $_SESSION['usergroup']= $row['Usergroup'];
                                $_SESSION['id']=$row['Vendor_ID'];

                                if(isset($_SESSION['valid'])){
                                    header("Location: /project/Module2/homefoodvendor.php");
                                    exit();
                                
                                }

                       
                    

                        }

                    
                        else{
                            echo "<div class='message'>
                            <p>Wrong Username or Password or User Group</p>
                            </div> <br>";
                            echo"<a href='login.php'><button class='btn'>Go Back</button>";

                        }
                        
                    }
                    
                    

                    
                    

                }else{
            
            ?>
            <header>Login</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" placeholder="   Username.." required>
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="   Password.." required>
                </div>

                <div class="field input">
                    <label for="usergroup">User Type</label>
                    <select value="Administrator" name="usergroup" id="usergroup" class="form-select" selected>
                        <option value="Administrator">Administrator</option>
                        <option value="Normal User">Registered User</option>
                        <option value="Food Vendor">Food Vendor</option>
                    </select>
                </div>

                <div class="field">
                    <input type="submit" name="submit"  class="btn" value="Login" required>
                </div>

                <div class="links">
                    Don't have account? <a href="register.php">Sign up</a>
                </div>

            </form>

        </div>
        <?php } ?>
    </div>

</body>
</html>
