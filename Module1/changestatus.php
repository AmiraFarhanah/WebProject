<?php
include("config.php");

if (isset($_GET['id'])) {
    
        $id = $_GET['id'];
    
       
            
            
            
                 // Delete the user with the specified username
                $updateQuery = "UPDATE food_vendor SET Status = 'Approved' where ID = '$id'";
                mysqli_query($con, $updateQuery);


                // Redirect back to the user list page
                header("Location: pending.php");
                exit();
}





else {
    
    exit();
}
?>
