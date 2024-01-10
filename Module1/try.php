<?php

@include 'connection.php';

session_start();
// error_reporting(0);

$userid = $_SESSION['User_ID'];

if (isset($_SESSION['User_ID'])) {
    // Retrieve user ID from the session
    $userID = $_SESSION['User_ID'];
    if ($_SESSION["user_type"] == "vendor") {
        $sql = "SELECT * FROM Vendor WHERE VendorID = ?";
    } else {
        $sql = "SELECT * FROM Customer WHERE CustomerID = ?";
    }

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userID);
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch data and return as an associative array
        $userData = $result->fetch_assoc();
        if ($_SESSION["user_type"] == "vendor") {
            $formValue = array(
                'user_ID' => $userData['VendorID'],
                'user_name' => $userData['VendorName'],
                'user_password' => $userData['VendorPassword'],
                'user_email' => $userData['VendorEmail']
            );
        } else {
            $formValue = array(
                'user_ID' => $userData['CustomerID'],
                'user_name' => $userData['CustomerName'],
                'user_password' => $userData['CustomerPassword'],
                'user_email' => $userData['CustomerEmail'],
                'user_image' => $userData['customer_image'],
            );
        }
    }
}
// Function to update user profile in the database
function updateUserProfile($userID, $userName, $password, $email, $conn)
{
    // Prepare the SQL statement to update user profile
    switch ($_SESSION["user_type"]) {
        case "student":
            $sql = "UPDATE Customer SET CustomerName = ?, CustomerPassword = ?, CustomerEmail = ? WHERE CustomerID = ?";
            break;
        case "staff":
            $sql = "UPDATE Customer SET Customername = ?, CustomerPassword = ?, CustomerEmail = ? WHERE CustomerID = ?";
            break;
        case "vendor":
            $sql = "UPDATE Vendor SET Vendorname = ?, VendorPassword = ?, VendorEmail = ? WHERE VendorID = ?";
            break;
        case "admin":
            $sql = "UPDATE Admin SET Adminname = ?, AdminPassword = ?, AdminEmail = ? WHERE AdminID = ?";
            break;
    }
    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $userName, $password, $email, $userID);

    // Execute the prepared statement to update user profile
    if ($stmt->execute()) {
        return true; // Profile updated successfully
    } else {
        return false; // Failed to update profile
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the 'submit' button is clicked
    if (isset($_POST['submits'])) {

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image = $_FILES['image'];
    
            // Check if it's a valid image file
            $allowedTypes = ['image/jpg', 'image/jpeg', 'image/png', 'image/webp'];
            if (in_array($image['type'], $allowedTypes)) {
                // Process the file
                $imageData = file_get_contents($image['tmp_name']);
    
                // TODO: Further processing or database update here
    
                echo '<script>';
                echo 'if (' . json_encode($sql) . ') {';
                echo '  if(confirm("Profile updated successfully.")) {';
                echo '    window.location.href = "user.update.php";'; // Replace with your desired page
                echo '  }';
                echo '} else {';
                echo '  alert("Failed to update profile.");';
                echo '}';
                echo '</script>';
            } else {
                echo "Invalid file type. Please upload an image.";
            }
        } else {
            echo "Error uploading file. Check the file size or other upload errors.";
        }
        $sql = "UPDATE Customer SET customer_image = ? WHERE CustomerID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $imageData, $userID);
    
        // Execute the prepared statement to update user profile
        if ($stmt->execute()) {
            return true; // Profile updated successfully
        } else {
            return false; // Failed to update profile
        }

    }

    if (isset($_POST['submit'])) {
        // Retrieve form data
        $userID = $_SESSION['User_ID'];
        $userName = $_POST['userName'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $userName = filter_var($userName, FILTER_SANITIZE_STRING);
    
        

        // Call the updateUserProfile function to update the user profile in the database
        $result = updateUserProfile($userID, $userName, $password, $email, $conn);

        // Display JavaScript pop-up based on the result
        echo '<script>';
        echo 'if (' . json_encode($result) . ') {';
        echo '  if(confirm("Profile updated successfully.")) {';
        echo '    window.location.href = "user.update.php";'; // Replace with your desired page
        echo '  }';
        echo '} else {';
        echo '  alert("Failed to update profile.");';
        echo '}';
        echo '</script>';
    }

    if (isset($_POST['delete'])) {
    
        // Delete the customer_image from the database
        $deleteQuery = "UPDATE Customer SET customer_image = NULL WHERE CustomerID = '$userid'";
        echo $deleteQuery;
        $result = mysqli_query($conn, $deleteQuery);
    
        if ($result) {
            // Photo successfully deleted
            echo "<script>alert('Photo successfully deleted.');window.location.href='user.update.php';</script>";
            exit;  // or die() if you prefer
        } else {
            // There was an error in the query
            echo "<script>alert('Error deleting photo.');</script>";
        }
    }
    
    // Additional code for user.update.php, if needed
    header("Location: user.update.php");
    exit;
    
}


if (!isset($_SESSION['login'])) {
    header('location:login.php');
}

if (isset($_POST['cancel'])) {
    header("location:user.home.php");
    exit;
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="banner">
        <div class="left-content"></div>
        <div class="center-content">
            <h1>FK-KIOSK</h1>
        </div>
        <div class="right-content">
            <a href="logout.php" class="dynamic-nav-button">
                logout
                <span class="icon">🔒</span>
            </a>
        </div>
    </div>

    <div class="topnav">
        <a href="user.home.php">Home</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="user.update.php">Profile</a>
    </div>
    <div class="main-content">
        <!-- Main content area -->
        <h2 align="center">User Profile</h2><br>
        <?php
        // Assuming $formValue['user_image'] contains the BLOB data
        $imageData = $formValue['user_image'];

        // Convert BLOB to Base64
        $base64Image = base64_encode($imageData);
        ?>
        <form action="" method="post" class="profile-form">

       
            <div class="form-group">
                <?php if ($base64Image !== ""): ?>
                    <img src="data:image/jpeg;base64,<?php echo $base64Image; ?>" alt="User Image">
                <?php endif; ?>
            </div>


            <div class="form-group">
                <label for="userID">User ID:</label>
                <input type="text" id="userID" name="userID" value="<?php echo $formValue['user_ID']; ?>" disabled>
            </div>
            <div class="form-group">
                <label for="userName">Fullname:</label>
                <input type="text" id="userName" value="<?php echo $formValue['user_name']; ?>" name="userName">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" value="<?php echo $formValue['user_password']; ?>">
            </div>
            <div class="form-group">
                <label for="cpassword">Confirm Password:</label>
                <input type="password" id="cpassword" name="cpassword" value="<?php echo $formValue['user_password']; ?>">
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $formValue['user_email']; ?>">
            </div>
            <button type="submit" name="submit">Update Profile</button><br><br>
            <button type="submit" name="cancel">Cancel</button>
            <br><br>

        </form>
        <form method="post"  class="profile-form" enctype="multipart/form-data">
            <div class="form-group">
            <input type="file" id="image" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required>
            </div>  
            <button type="submit" name="submits" class="submitsbtn">Add Photo</button><br><br>

        </form>

        <form method="post"  class="profile-form" enctype="multipart/form-data">
        <button type="submit" name="delete">Delete Photo</button><br><br>
        </form>
        
    </div>
</body>

</html>