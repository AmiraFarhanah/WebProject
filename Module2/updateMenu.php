<?php
session_start();
include("../config.php");

if (!isset($_SESSION['valid'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $menuID = $_POST['ID'];
    $foodname = $_POST['foodname'];
    $fooddescription = $_POST['fooddescription'];
    $FoodPrice = $_POST['FoodPrice'];

    // Handle file upload
    if (isset($_FILES['new_foodimage']) && $_FILES['new_foodimage']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($_FILES['new_foodimage']['name']);

        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (move_uploaded_file($_FILES['new_foodimage']['tmp_name'], $uploadFile)) {
            $newFoodImageFilePath = $uploadDir . basename($_FILES['new_foodimage']['name']);

            $sql = "UPDATE menu SET 
                Foodname='$foodname', 
                FoodDescription='$fooddescription', 
                FoodPrice='$FoodPrice',
                FoodImage='$newFoodImageFilePath'  
                WHERE ID='$menuID'";

            $result = mysqli_query($con, $sql);

            if ($result) {
                header("Location: /WebProject/Module2/homefoodvendor.php");
                exit();
            } else {
                echo "Error updating menu item: " . mysqli_error($con);
            }
        } else {
            echo '<p>Failed to upload new image.</p>';
        }
    } else {
        $sql = "UPDATE menu SET 
            Foodname='$foodname', 
            FoodDescription='$fooddescription', 
            FoodPrice='$FoodPrice' 
            WHERE ID='$menuID'";

        $result = mysqli_query($con, $sql);

        if ($result) {
            header("Location: /WebProject/Module2/homefoodvendor.php");
            exit();
        } else {
            echo "Error updating menu item: " . mysqli_error($con);
        }
    }
}
?>
