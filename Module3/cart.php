<!-- Cart  -->

<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Cart</title>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css' />
</head>

<body>
  <nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <a class="navbar-brand" href="UserDashboard.php">Faculty of Computing</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link active" href="home.php">Menu</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="checkoutt.php"><i class="fas fa-money-check-alt mr-2"></i>Checkout</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i> <span id="cart-item" class="badge badge-danger"></span></a>
        </li>
      </ul>
    </div>
  </nav>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div style="display:<?php if (isset($_SESSION['showAlert'])) {
  echo $_SESSION['showAlert'];
} else {
  echo 'none';
} unset($_SESSION['showAlert']); ?>" class="alert alert-success alert-dismissible mt-3">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong><?php if (isset($_SESSION['message'])) {
  echo $_SESSION['message'];
} unset($_SESSION['showAlert']); ?></strong>
        </div>
        <div class="table-responsive mt-2">
          <table class="table table-bordered table-striped text-center">
            <thead>
              <tr>
                <td colspan="7">
                  <h4 class="text-center text-info m-0">Products in your cart!</h4>
                </td>
              </tr>
              <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>
                  <a href="action.php?clear=all" class="badge-danger badge p-1" onclick="return confirm('Are you sure want to clear your cart?');"><i class="fas fa-trash"></i>&nbsp;&nbsp;Clear Cart</a>
                </th>
              </tr>
            </thead>
            <tbody>
              <?php
                require 'config1.php';
                $stmt = $conn->prepare('SELECT * FROM payment');
                $stmt->execute();
                $result = $stmt->get_result();
                $grand_total = 0;
                while ($row = $result->fetch_assoc()):
              ?>
              <tr>
                <input type="hidden" class="pid" value="<?= $row['MenuID'] ?>">
                <td><img src="<?= $row['MenuImg'] ?>" width="50"></td>
                <td><?= $row['MenuName'] ?></td>
                <td>
                  <i class="fas fa-ringgit-sign"></i>&nbsp;&nbsp;<?= number_format($row['MenuPrice'],2); ?>
                </td>
                <input type="hidden" class="pprice" value="<?= $row['MenuPrice'] ?>">
                <td>
                  <input type="number" class="form-control itemQty" value="<?= $row['Menuqty'] ?>" style="width:75px;">
                </td>
                <td><i class="fas fa-ringgit-sign"></i>&nbsp;&nbsp;<?= number_format($row['totalprice'],2); ?></td>
                <td>
                  <a href="action.php?remove=<?= $row['MenuID'] ?>" class="text-danger lead" onclick="return confirm('Are you sure want to remove this item?');"><i class="fas fa-trash-alt"></i></a>
                </td>
              </tr>
              <?php $grand_total += $row['totalprice']; ?>
              <?php endwhile; ?>
              <tr>
                <td colspan="3">
                  <a href="Home.php" class="btn btn-success"><i class="fas fa-cart-plus"></i>&nbsp;&nbsp;Add More Item
                    </a>
                </td>
                <td colspan="2"><b>Grand Total</b></td>
                <td><b><i class="fas fa-ringgit-sign"></i>&nbsp;&nbsp;<?= number_format($grand_total,2); ?></b></td>
                <td>
                  <a href="checkoutt.php" class="btn btn-info <?= ($grand_total > 1) ? '' : 'disabled'; ?>"><i class="far fa-credit-card"></i>&nbsp;&nbsp;Checkout</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>

  <script type="text/javascript">
  $(document).ready(function() {
    $(".itemQty").on('change', function() {
        var $el = $(this).closest('tr');
        var pid = $el.find(".pid").val();
        var pprice = parseFloat($el.find(".pprice").val());
        var qty = parseInt($(this).val());

        $.ajax({
            url: 'action.php',
            method: 'post',
            cache: false,
            data: {
                qty: qty,
                pid: pid,
                pprice: pprice,
                action: 'update'
            },
            success: function(response) {
                var data = JSON.parse(response);

                // Update the total price and grand total
                $el.find(".Total_price").text('RM ' + data.total_price.toFixed(2));
                $("#grand-total").text('RM ' + data.grand_total.toFixed(2));
            }
        });
    });





    load_cart_item_number();

    function load_cart_item_number() {
      $.ajax({
        url: 'action.php',
        method: 'get',
        data: {
          cartItem: "cart_item"
        },
        success: function(response) {
          $("#cart-item").html(response);
        }
      });
    }
  });
  </script>
</body>

</html>
