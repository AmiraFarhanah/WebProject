<?php
session_start();
include("config.php");

// Handle adding items to the cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['id'])) {
    $foodId = $_POST['ID'];
    $userId = $_SESSION['id'];

    // Perform the necessary logic to add the item to the cart
    // For simplicity, let's assume you have a cart table in your database
    // You need to adjust this based on your actual database structure

    // Insert the item into the cart table
    $insertQuery = mysqli_query($con, "INSERT INTO cart (UserID, ID) VALUES ('$userId', '$foodId')");

    if ($insertQuery) {
        // Redirect to the cart page or send a success message
        header('Location: cart.php');
        exit();
    } else {
        echo 'Error adding item to cart';
    }
}
 else {
    echo 'Invalid request';
}



if(isset($_POST['update_update_btn'])){
   $update_value = $_POST['update_quantity'];
   $update_id = $_POST['update_quantity_id'];
   $update_quantity_query = mysqli_query($conn, "UPDATE `menu-list` SET quantity = '$update_value' WHERE id = '$update_id'");
   if($update_quantity_query){
      header('location:cart1.php');
   };
};

if(isset($_GET['remove'])){
   $remove_id = $_GET['remove'];
   mysqli_query($con, "DELETE FROM `menu-list` WHERE id = '$remove_id'");
   header('location:cart1.php');
};

if(isset($_GET['delete_all'])){
   mysqli_query($con, "DELETE FROM `order_item`");
   header('location:cart1.php');
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shopping cart</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">
   

</head>
<style>
   .container5
   {
      background-attachment: fixed;
      background-color:white;
      
   }
</style>
<body>

<!--<-?php include 'home.php'; ?>-->

<div class="container5" >

<section class="shopping-cart">

   <h1 class="heading">shopping cart</h1>

   <table>

      <thead>
         <th>image</th>
         <th>name</th>
         <th>price</th>
         <th>quantity</th>
         <th>total price</th>
         <th>action</th>
      </thead>

      <tbody>

         <?php 
         
         $select_cart = mysqli_query($con, "SELECT * FROM `menu`");
         $grand_total = 0;
         if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
         ?>

         <tr>
            <td><img src="//WebProject/Module2/<?php echo $fetch_cart['FoodImage']; ?>" height="100" alt=""></td>
            <td><?php echo $fetch_cart['foodname']; ?></td>
            <td>RM<?php echo number_format($fetch_cart['FoodPrice']); ?>/-</td>
            <td>
               <form action="" method="post">
                  <input type="hidden" name="update_quantity_id"  value="<?php echo $fetch_cart['ID']; ?>" >
                  <input type="number" name="update_quantity" min="1"  value="<?php echo $fetch_cart['FoodQuantity']; ?>" >
                  <input type="submit" value="update" name="update_update_btn">
               </form>   
            </td>
            <td>RM<?php echo $sub_total = number_format($fetch_cart['FoodPrice'] * $fetch_cart['FoodQuantity']); ?>/-</td>
            <td><a href="cart.php?remove=<?php echo $fetch_cart['id']; ?>" onclick="return confirm('remove item from cart?')" class="delete-btn"> <i class="fas fa-trash"></i> remove</a></td>
         </tr>
         <?php
           $grand_total += $sub_total;  
            };
         };
         ?>
         <tr class="table-bottom">
            <td><a href="products.php" class="option-btn" style="margin-top: 0;">continue shopping</a></td>
            <td colspan="3"> Total</td>
            <td>RM<?php echo $grand_total; ?>/-</td>
            <td><a href="cart.php?delete_all" onclick="return confirm('are you sure you want to delete all?');" class="delete-btn"> <i class="fas fa-trash"></i> delete all </a></td>
         </tr>

      </tbody>

   </table>

   <div class="checkout-btn">
      <a href="checkout.php" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>">proceed to checkout</a>
   </div>

</section>

</div>
   
<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>