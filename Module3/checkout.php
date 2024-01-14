<?php

@include 'config.php';


// Assuming you want to handle the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check which button was clicked
    if (isset($_POST['membershipCardPayment'])) {
        // Handle membership card payment logic
        echo "Processing Kiosk Membership Card Payment";
    } elseif (isset($_POST['cashPayment'])) {
        // Handle cash payment logic
        echo "Processing Cash Payment (pay at counter)";
    } elseif (isset($_POST['onlinePayment'])) {
        // Handle online payment logic
        echo "Processing Online Payment";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">

</head>
<body>


<div class="container">

<section class="checkout-form">

   <h1 class="heading">complete your order</h1>

   <form action="" method="post">

   <div class="display-order">
      <?php
         $select_cart = mysqli_query($con, "SELECT * FROM `order_item`");
         $total = 0;
         $grand_total = 0;
         if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = number_format($fetch_cart['Totalpayment'] * $fetch_cart['quantity']);
            $grand_total = $total += $total_price;
      ?>
      <span><?= $fetch_cart['name']; ?>(<?= $fetch_cart['quantity']; ?>)</span>
      <?php
         }
      }else{
         echo "<div class='display-order'><span>your cart is empty!</span></div>";
      }
      ?>
      <span class="grand-total"> grand total : RM<?= $grand_total; ?> </span>
   </div>

   <!DOCTYPE html>
<html>
<html lang="en"></html>
<head>

<link rel="stylesheet" type="text/css" href="paymentoption.css"> 
<meta charset=" UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Payment Option</title>
</head>

<body>
    <div class="container">
        
        <?php
    // Check if the referring page is set in the HTTP Referer header
        if (isset($_SERVER['HTTP_REFERER'])) {
      $backUrl = $_SERVER['HTTP_REFERER'];
  } else {
      // If no referring page, set a default URL
      $backUrl = 'index.php';
  }
  ?>

  <button onclick="goBack()">Back</button>

  <script>
    function goBack() {
      window.location.href = "<?php echo $backUrl; ?>";
    }



  </script>


        <h3>Payment Option</h3>
    </div>


    <div class="payment">
        <input type="submit"  id="menu" value="Kiosk Membership Card Payment" onsubmit="">
        <input type="submit"  id="order" value="Cash (pay at counter)" onsubmit="">
        <input type="submit"  id="order" value="Online Payment" onsubmit="">
    </div>
    
  

</body>
</html>



</section>

</div>

<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>