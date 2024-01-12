<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Sign Up</title>

</head>
<body>
    <div class="container">
        <div class="kotak form-kotak">

        <?php
            include("config.php");
            if(isset($_POST['submit'])){
                $name=$_POST['name'];
                $username=$_POST['username'];
                $password=$_POST['password'];
                $address=$_POST['address'];
                $phonenumber=$_POST['phonenumber'];
                $usergroup=$_POST['usergroup'];
                $email=$_POST['email'];
                

                $qrcode='<img src= "https://api.qrserver.com/v1/create-qr-code/?data='.$name. '&size=100x100">';

                if($usergroup=="Normal User"){
                    //verify the unique username

                $verify_query=mysqli_query($con, "SELECT Username FROM registered_user WHERE Username= '$username' ");
                
                if(mysqli_num_rows($verify_query)!=0){
                    echo "<div class='message'>
                        <p>This username has been used, Try another one!</p>
                        </div><br>";

                    echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";

                }
                else{
                    
                    mysqli_query($con, "INSERT INTO registered_user (Name, Password, Address, Phonenumber, Username, Usergroup, Email, Qrcode) VALUES ('$name', '$password', '$address', '$phonenumber', '$username', '$usergroup', '$email', '$qrcode')") or die("Error Occured");
                    echo "<div class='qrcode'>$qrcode</div>";
                    echo "<div class='message'>
                        <p>Registeration successfully!</p>
                        </div><br>";
                        

                    echo "<a href='login.php'><button class='btn'>Login Now</button>";

                }

                }
                else if($usergroup=="Food Vendor"){
                    $verify_query=mysqli_query($con, "SELECT Username FROM food_vendor WHERE Username= '$username' ");
                
                if(mysqli_num_rows($verify_query)!=0){
                    echo "<div class='message'>
                        <p>This username has been used, Try another one!</p>
                        </div><br>";

                    echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";

                }
                else{
                    
                    mysqli_query($con, "INSERT INTO food_vendor (Name, Password, Address, Phonenumber, Username, Usergroup, Email, Qrcode) VALUES ('$name', '$password', '$address', '$phonenumber', '$username', '$usergroup', '$email', '$qrcode')") or die("Error Occured");
                    echo "<div class='qrcode'>$qrcode</div>";
                    echo "<div class='message'>
                        <p>Registeration successfully!</p>
                        </div><br>";
                       
                        echo "<a href='login.php'><button class='btn'>Login Now</button>";
                    

                }


                }

                

            }else{
        ?>



            <header>Sign Up</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="Name">Name</label>
                    <input type="text" name="name" id="name" placeholder="   Name.." required>
                </div>
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" placeholder="   Username.." required>
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="   Password.." required>
                </div>

                <div class="field input">
                    <label for="address">Address</label>
                    <input type="text" name="address" id="address" placeholder="   Address.." required>
                </div>

                <div class="field input">
                    <label for="phonenumber">Phone Number</label>
                    <input type="text" name="phonenumber" id="phonenumber" placeholder="   Phone number..." required>
                </div>

                <div class="field input">
                    <label for="email">Email Address</label>
                    <input type="text" name="email" id="email" placeholder="   Email..." required>
                </div>

                
                <div class="field input">
                    <label for="usergroup">User Type</label>
                    <select value="Normal User" name="usergroup" id="usergroup" class="form-select" selected>
                        
                        <option value="Normal User">Registered User</option>
                        <option value="Food Vendor">Food Vendor</option>
                    </select>
                </div>

                <div>

                <div class="field">
                    <input type="submit" name="submit" class="btn" value="Register" required>
                </div>

                

                <div class="links">
                    Already have account? <a href="login.php">Sign In</a>
                </div>

            </form>

        </div>
        

        <?php }?>
    </div>

</body>
</html>
