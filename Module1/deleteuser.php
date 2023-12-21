<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home admin</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<?php
include("config.php");

if (isset($_GET['username'])) {
    
    $username = $_GET['username'];
    
        if(isset($_GET['usergroup'])){
            $usergroup= $_GET['usergroup'];
            
            
            if($usergroup=="Administrator"){
                 // Delete the user with the specified username
                 
                    echo "<div class='message'>
                    <p>You cannot delete the administrator</p>
                    </div><br>";
                    echo "<a href='Userlist.php'><button class='btn'>Go back</button>";
                


            }
            else if($usergroup=="Food Vendor"){
                // Delete the user with the specified username
               $deleteQuery = "DELETE FROM food_vendor WHERE Username = '$username'";
           mysqli_query($con, $deleteQuery);
           header("Location: Userlist.php");
    exit();


           }
           else if($usergroup=="Normal User"){
            // Delete the user with the specified username
           $deleteQuery = "DELETE FROM registered_user WHERE Username = '$username'";
           mysqli_query($con, $deleteQuery);
           header("Location: Userlist.php");
    exit();


       }

    
    
    }

    // Redirect back to the user list page
    
}





else {
    // Handle the case where the 'username' parameter is not set
    echo "Username not set";
    exit();
}
?>
</html>