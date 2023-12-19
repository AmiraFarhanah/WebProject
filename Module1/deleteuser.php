<?php
include("config.php");

if (isset($_GET['username'])) {
    
    $username = $_GET['username'];
    
        if(isset($_GET['usergroup'])){
            $usergroup= $_GET['usergroup'];
            
            
            if($usergroup=="Administrator"){
                 // Delete the user with the specified username
                $deleteQuery = "DELETE FROM administrator WHERE Username = '$username'";
            mysqli_query($con, $deleteQuery);


            }
            else if($usergroup=="Food Vendor"){
                // Delete the user with the specified username
               $deleteQuery = "DELETE FROM food_vendor WHERE Username = '$username'";
           mysqli_query($con, $deleteQuery);


           }
           else if($usergroup=="Normal User"){
            // Delete the user with the specified username
           $deleteQuery = "DELETE FROM registered_user WHERE Username = '$username'";
           mysqli_query($con, $deleteQuery);


       }

    
    
    }

    // Redirect back to the user list page
    header("Location: Userlist.php");
    exit();
}





else {
    // Handle the case where the 'username' parameter is not set
    echo "Username not set";
    exit();
}
?>
