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
    $availableDays = [
        'Sunday' => isset($_POST['Sunday']) ? 1 : 0,
        'Monday' => isset($_POST['Monday']) ? 1 : 0,
        'Tuesday' => isset($_POST['Tuesday']) ? 1 : 0,
        'Wednesday' => isset($_POST['Wednesday']) ? 1 : 0,
        'Thursday' => isset($_POST['Thursday']) ? 1 : 0,
        'Friday' => isset($_POST['Friday']) ? 1 : 0,
        'Saturday' => isset($_POST['Saturday']) ? 1 : 0,
    ];

    // Convert the array to a comma-separated string for database storage
    $availableDaysString = implode(',', $availableDays);
    

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
            $newFoodImageFilePath = $uploadDir . basename($_FILES['new_foodimage']['name']);

            // Update data in the database including the new image path
            $sql = "UPDATE menu SET 
            Foodname='$foodname', 
            FoodQuantity='$foodquantity', 
            FoodDescription='$fooddescription', 
            FoodStatus='$foodstatus',
            FoodImage = '$newFoodImageFilePath', 
            Sunday='" . $_POST['Sunday'] . "', 
            Monday='" . $_POST['Monday'] . "', 
            Tuesday='" . $_POST['Tuesday'] . "', 
            Wednesday='" . $_POST['Wednesday'] . "', 
            Thursday='" . $_POST['Thursday'] . "', 
            Friday='" . $_POST['Friday'] . "', 
            Saturday='" . $_POST['Saturday'] . "' 
            WHERE Menu_ID='$menuID'";


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
        // No new image provided, update other fields only
        $sql = "UPDATE menu SET 
    Foodname='$foodname', 
    FoodQuantity='$foodquantity', 
    FoodDescription='$fooddescription', 
    FoodStatus='$foodstatus', 
    Sunday='" . $_POST['Sunday'] . "', 
    Monday='" . $_POST['Monday'] . "', 
    Tuesday='" . $_POST['Tuesday'] . "', 
    Wednesday='" . $_POST['Wednesday'] . "', 
    Thursday='" . $_POST['Thursday'] . "', 
    Friday='" . $_POST['Friday'] . "', 
    Saturday='" . $_POST['Saturday'] . "' 
    WHERE Menu_ID='$menuID'";

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
