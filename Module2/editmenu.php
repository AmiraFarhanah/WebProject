<?php
    session_start();
    include("../config.php");

    if (!isset($_SESSION['valid'])) {
        header("Location: ../login.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['menu_id'])) {
        $menuID = $_GET['menu_id'];

        $query = mysqli_query($con, "SELECT * FROM menu WHERE Menu_ID='$menuID'");
        $menuItem = mysqli_fetch_assoc($query);

        // Display the form for editing
        ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Food Vendor</title>
    <link rel="stylesheet" href="\WebProject\Module2\editmenu.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>

<body>
    <div class="hero">
        <nav>
            <a href="/WebProject/Module2/homefoodvendor.php" class="/WebProject/Module1/logo"></a>
            <ul>
                <li><a href="WebProject/Module2/homefoodvendor.php">Home</a></li>
                <li><a href="#">Order List</a></li>
                <li><a href="#">Dashboard</a></li>
            </ul>
            <img src="/WebProject/Module1/login.png" class="user-pic" onclick="toggleMenu()">
            <div class="sub-menu-wrap" id="subMenu">
                <div class="sub-menu">
                    <div class="user-info">
                        <img src="/WebProject/Module1/login.png" style="margin-right: 10px;">
                        <?php
                        $id = $_SESSION['id'];
                        $res_name = null;
                        $query = mysqli_query($con, "SELECT * FROM food_vendor where ID='$id'");
                        if (!$query) {
                            die("Query failed: " . mysqli_error($con));
                        }
                        if ($result = mysqli_fetch_assoc($query)) {
                            $res_name = $result['Name'];
                            echo "<h3>$res_name</h3>";
                        } else {
                            echo "<h3>No Name Found</h3>"; // or handle the case where the name is not found
                        }
                        ?>
                    </div>
                    <hr>
                    <div>
                        <?php
                        $id = $_SESSION['id'];
                        $query = mysqli_query($con, "SELECT * FROM food_vendor where ID='$id'");
                        $res_id = null;
                        while ($result = mysqli_fetch_assoc($query)) {
                            $res_name = $result['Name'];
                            $res_username = $result['Username'];
                            $res_password = $result['Password'];
                            $res_address = $result['Address'];
                            $res_phonenumber = $result['Phonenumber'];
                            $res_email = $result['Email'];
                            $res_id = $result['ID'];
                        }

                        echo "<a href='/WebProject/Module1/editvendor.php?Id=$res_id' class='sub-menu-link'>
                            <img src='/WebProject/Module1/icon/edit.png' >
                            <p>Edit Profile</p>
                            <span>></span>
                        </a>";

                        echo "<a href='/WebProject/Module1/logout.php' class='sub-menu-link'>
                            <img src='/WebProject/Module1/icon/logout.png' >
                            <p>Log Out</p>
                            <span>></span>
                        </a>";
                        ?>
                    </div>
                </div>
            </div>
        </nav>
    </div>
        <h2 class="text">Edit Menu Item</h2>
        <form class="edit-form" method="post" action="/WebProject/Module2/updateMenu.php" enctype="multipart/form-data">
    <input type="hidden" name="menu_id" value="<?php echo $menuItem['Menu_ID']; ?>">
    <label for="foodname">Foodname:</label>
    <input type="text" name="foodname" id="foodname" class="form-input" value="<?php echo $menuItem['Foodname']; ?>" required><br>

    <label for="foodquantity">FoodQuantity:</label>
    <input type="number" name="foodquantity" id="foodquantity" class="form-input" value="<?php echo $menuItem['FoodQuantity']; ?>" required><br>

    <label for="fooddescription">FoodDescription:</label>
    <textarea name="fooddescription" id="fooddescription" class="form-input" required><?php echo $menuItem['FoodDescription']; ?></textarea><br>

    <label for="foodstatus">FoodStatus:</label>
    <input type="text" name="foodstatus" id="foodstatus" class="form-input" value="<?php echo $menuItem['FoodStatus']; ?>" required><br>

    <!-- Add input for updating the image -->
    <label for="new_foodimage">New FoodImage:</label>
    <input type="file" name="new_foodimage" id="new_foodimage" class="form-input" accept="image/*"><br>

    <label for="available_days">Available Days:</label><br>
<input type="checkbox" name="Sunday" value="1" <?php if ($menuItem['Sunday'] == 1) echo 'checked'; ?>> Sunday
<input type="checkbox" name="Monday" value="1" <?php if ($menuItem['Monday'] == 1) echo 'checked'; ?>> Monday
<input type="checkbox" name="Tuesday" value="1" <?php if ($menuItem['Tuesday'] == 1) echo 'checked'; ?>> Tuesday
<input type="checkbox" name="Wednesday" value="1" <?php if ($menuItem['Wednesday'] == 1) echo 'checked'; ?>> Wednesday
<input type="checkbox" name="Thursday" value="1" <?php if ($menuItem['Thursday'] == 1) echo 'checked'; ?>> Thursday
<input type="checkbox" name="Friday" value="1" <?php if ($menuItem['Friday'] == 1) echo 'checked'; ?>> Friday
<input type="checkbox" name="Saturday" value="1" <?php if ($menuItem['Saturday'] == 1) echo 'checked'; ?>> Saturday
<br>              


    <input type="submit" name="update" class="submit-button" value="Update Menu">

</form>

    </body>

    </html>
<?php
}
?>
