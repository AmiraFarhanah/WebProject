<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bro Code</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>
    <div class="hero">
        <nav>
            <a href="home.php" class="logo"></a>
        </div>       
<?php
session_start();
include("config.php");

if (!isset($_SESSION['valid'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['menu_id'])) {
    $menuID = $_GET['menu_id'];

    $query = mysqli_query($con, "SELECT * FROM menu WHERE Menu_ID='$menuID'");
    $menuItem = mysqli_fetch_assoc($query);

    // Display the form for editing
?>
    </nav>
</div>
<h2>Edit Menu Item</h2>
<form method="post" action="updatemenu.php" enctype="multipart/form-data">
    <input type="hidden" name="menu_id" value="<?php echo $menuItem['Menu_ID']; ?>">
    Foodname: <input type="text" name="foodname" value="<?php echo $menuItem['Foodname']; ?>" required><br>
    FoodQuantity: <input type="number" name="foodquantity" value="<?php echo $menuItem['FoodQuantity']; ?>" required><br>
    FoodDescription: <textarea name="fooddescription" required><?php echo $menuItem['FoodDescription']; ?></textarea><br>
    FoodStatus: <input type="text" name="foodstatus" value="<?php echo $menuItem['FoodStatus']; ?>" required><br>
    <!-- Add input for updating the image -->
    New FoodImage: <input type="file" name="new_foodimage" accept="image/*"><br>
    <input type="submit" name="update" value="Update Menu">
</form>
</body>
</html>
<?php
}
?>
