<?php
session_start();
include("../config.php");

if (!isset($_SESSION['valid'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $menuID = $_POST['menu_id'];
    $foodname = $_POST['foodname'];
    $foodquantity = $_POST['foodquantity'];
    $fooddescription = $_POST['fooddescription'];
    $foodstatus = $_POST['foodstatus'];

    // Handle file upload
    if (isset($_FILES['new_foodimage']) && $_FILES['new_foodimage']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($_FILES['new_foodimage']['name']);

        // Create the upload directory if it doesn't exist
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (move_uploaded_file($_FILES['new_foodimage']['tmp_name'], $uploadFile)) {
            // File successfully uploaded, now you can store the file path in the database
            $newFoodImageFilePath = $uploadFile;

            // Update data in the database including the new image path
            $sql = "UPDATE menu SET 
                    Foodname = '$foodname',
                    FoodQuantity = $foodquantity,
                    FoodDescription = '$fooddescription',
                    FoodStatus = '$foodstatus',
                    FoodImage = '$newFoodImageFilePath'
                    WHERE Menu_ID = '$menuID'";

            $result = mysqli_query($con, $sql);

            if ($result) {
                header("Location: /project/Module2/homefoodvendor.php");
                exit();
            } else {
                echo "Error updating menu item: " . mysqli_error($con);
            }
        } else {
            echo '<p>Failed to upload new image.</p>';
        }
    } else {
        // No new image provided, update other fields only
        $sql = "UPDATE menu SET 
                Foodname = '$foodname',
                FoodQuantity = $foodquantity,
                FoodDescription = '$fooddescription',
                FoodStatus = '$foodstatus'
                WHERE Menu_ID = '$menuID'";

        $result = mysqli_query($con, $sql);

        if ($result) {
            header("Location: /project/Module2/homefoodvendor.php");
            exit();
        } else {
            echo "Error updating menu item: " . mysqli_error($con);
        }
    }
}
?>
