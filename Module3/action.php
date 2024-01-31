<!-- Action  -->

<?php
	session_start();
	require 'config.php';

	if (isset($_POST['pid'])) {
	  $pid = $_POST['pid'];
	  $pname = $_POST['pname'];
	  $pprice = $_POST['pprice'];
	  $pimage = $_POST['pimage'];
	  $pcode = $_POST['pcode'];
	  $pqty = $_POST['pqty'];
	  $total_price = $pprice * $pqty;

	  $stmt = $conn->prepare('SELECT MenuCode FROM payment WHERE MenuCode=?');
	  $stmt->bind_param('s',$pcode);
	  $stmt->execute();
	  $res = $stmt->get_result();
	  $r = $res->fetch_assoc();
	  $code = $r['MenuCode'] ?? '';

	  if (!$code) {
	    $query = $conn->prepare('INSERT INTO payment (MenuName,MenuPrice,MenuImg,Menuqty,totalprice,MenuCode) VALUES (?,?,?,?,?,?)');
	    $query->bind_param('ssssss',$pname,$pprice,$pimage,$pqty,$total_price,$pcode);
	    $query->execute();

	    echo '<div class="alert alert-success alert-dismissible mt-2">
						  <button type="button" class="close" data-dismiss="alert">&times;</button>
						  <strong>Item added to your cart!</strong>
						</div>';
	  } else {
	    echo '<div class="alert alert-danger alert-dismissible mt-2">
						  <button type="button" class="close" data-dismiss="alert">&times;</button>
						  <strong>Item already added to your cart!</strong>
						</div>';
	  }
	}

	if (isset($_GET['cartItem']) && isset($_GET['cartItem']) == 'cart_item') {
	  $stmt = $conn->prepare('SELECT * FROM payment');
	  $stmt->execute();
	  $stmt->store_result();
	  $rows = $stmt->num_rows;

	  echo $rows;
	}

	if (isset($_GET['remove'])) {
	  $id = $_GET['remove'];

	  $stmt = $conn->prepare('DELETE FROM payment WHERE MenuID=?');
	  $stmt->bind_param('i',$id);
	  $stmt->execute();

	  $_SESSION['showAlert'] = 'block';
	  $_SESSION['message'] = 'Item removed from the cart!';
	  header('location:cart.php');
	}

	if (isset($_GET['clear'])) {
	  $stmt = $conn->prepare('DELETE FROM payment');
	  $stmt->execute();
	  $_SESSION['showAlert'] = 'block';
	  $_SESSION['message'] = 'All Item removed from the cart!';
	  header('location:cart.php');
	}

// Inside the block that updates the quantity
// Inside the block that updates the quantity
if (isset($_POST['action']) && $_POST['action'] == 'update') {
    $qty = $_POST['qty'];
    $pid = $_POST['pid'];
    $pprice = $_POST['pprice'];

    $tprice = $qty * $pprice;

    $stmt = $conn->prepare('UPDATE payment SET Menuqty=?, totalprice=? WHERE CartID=?');
    $stmt->bind_param('idi', $qty, $tprice, $pid);
    $stmt->execute();

    // Calculate and retrieve updated total price and grand total
    $stmt = $conn->prepare('SELECT SUM(totalprice) AS grand_total FROM payment');
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $grand_total = $row['grand_total'];

    $response = array(
        'total_price' => $tprice,
        'grand_total' => $grand_total
    );

    echo json_encode($response);
}





	if (isset($_POST['action']) && isset($_POST['action']) == 'order') {
	  $name = $_POST['name'];
	  $phone = $_POST['phone'];
	  $products = $_POST['products'];
	  $grand_total = $_POST['grand_total'];
	  $pmode = $_POST['pmode'];

	  $data = '';

	  $stmt = $conn->prepare('INSERT INTO order (pmode, menus, Order_price) VALUES (?, ?, ?)');
      $stmt->bind_param('sss', $pmode, $products, $grand_total);
      $stmt->execute();


	  $stmt2 = $conn->prepare('DELETE FROM payment');
	  $stmt2->execute();
	  $qrCodeValue = "Name: $name,
	  Phone Number : $phone, 
	  Order Details : $products, 
	  Total : $grand_total, 
	  Payment mode : $pmode
	                 ";
	  $qrCodeSrc = "https://api.qrserver.com/v1/create-qr-code/?size=170x170&data=" . urlencode($qrCodeValue);
  
	  $data .= '<h1 class="display-4 mt-2 text-danger">Thank You!</h1>
	  <h2 class="text-success">Your Order Placed Successfully!</h2>
	  <h4>Please show this QR at kiosk [kiosk number]</h4>
	  <div class="qr-code text-center">
	  <img src="' . $qrCodeSrc . '" alt="QR Code">
	  </div>';
	  echo $data;
	}
?>
