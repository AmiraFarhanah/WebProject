<!-- Homepage  -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <style>

  /* Navbar styling */
  .navbar {
    background-color: #ff4d4d; /* Darker shade of red */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }

  .navbar-brand, .nav-link {
    color: #ffffff !important; /* White text */
  }

  .navbar-toggler-icon {
    background-color: #ffffff;
  }

  /* Product card styling */
  .card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
  }

  .card:hover {
    transform: scale(1.05);
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
  }

  .card-title {
    font-size: 1.2rem;
    margin-bottom: 0.5rem;
  }

  .card-text {
    font-size: 1rem;
  }

  .btn-info {
    transition: background-color 0.3s ease-in-out, border-color 0.3s ease-in-out, color 0.3s ease-in-out;
  }

  .btn-info:hover {
    background-color: #2979b9; /* Darker shade of blue on hover */
    border-color: #2979b9;
  }

  /* Footer styling */
  .footer {
    background-color: #34495e; /* Dark blue */
    color: #ffffff;
    padding: 15px 0;
  }

  .footer-buttons button {
    width: 40%;
  }

  .footer-buttons button:hover {
    background-color: #2979b9; /* Darker shade of blue on hover */
    border-color: #2979b9;
  }

</style>
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css' />
</head>

<body>
    
  <nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <a class="navbar-brand" href="home.php"> Faculty of Computing</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link active" href="home.php">Menu</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i> <span id="cart-item" class="badge badge-danger"></span></a>
        </li>
      </ul>
    </div>
  </nav>

 
  <!-- display products  -->
  <div class="container">
  <br>
        
    <div id="message"></div>
    <div class="row mt-2 pb-3">
      <?php
  			include 'config1.php';
  			$stmt = $conn->prepare('SELECT * FROM menu');
  			$stmt->execute();
  			$result = $stmt->get_result();
  			while ($row = $result->fetch_assoc()):

  		?>
      <div class="col-sm-6 col-md-4 col-lg-3 mb-2">
        <div class="card-deck">
          <div class="card p-2 border-secondary mb-2">
            <img src="<?= $row['MenuImg'] ?>" class="card-img-top" height="250">
            <div class="card-body p-1">
              <h4 class="card-title text-center text-info"><?= $row['MenuName'] ?></h4>
              <h5 class="card-text text-center text-danger"><i class="fas fa-ringgit-sign"></i>&nbsp;&nbsp;<?= number_format($row['MenuPrice'],2) ?></h5>

            </div>
            <div class="card-footer p-1">
              <form action="" class="form-submit">
                <div class="row p-2">
                  <div class="col-md-6 py-1 pl-4">
                    <b>Quantity : </b>
                  </div>
                  <div class="col-md-6">
                    <input type="number" class="form-control pqty" value="<?= $row['Menuqty'] ?>">
                  </div>
                </div>
                <input type="hidden" class="pid" value="<?= $row['MenuID'] ?>">
                <input type="hidden" class="pname" value="<?= $row['MenuName'] ?>">
                <input type="hidden" class="pprice" value="<?= $row['MenuPrice'] ?>">
                <input type="hidden" class="pimage" value="<?= $row['MenuImg'] ?>">
                <input type="hidden" class="pcode" value="<?= $row['MenuCode'] ?>">
                <button class="btn btn-info btn-block addItemBtn"><i class="fas fa-cart-plus"></i>&nbsp;&nbsp;Add to
                  cart</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <?php endwhile; ?>
    </div>
  </div>

  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>

  <script type="text/javascript">
  $(document).ready(function() {

    // Send product details in the server
    $(".addItemBtn").click(function(e) {
      e.preventDefault();
      var $form = $(this).closest(".form-submit");
      var pid = $form.find(".pid").val();
      var pname = $form.find(".pname").val();
      var pprice = $form.find(".pprice").val();
      var pimage = $form.find(".pimage").val();
      var pcode = $form.find(".pcode").val();
 
      var pqty = $form.find(".pqty").val();

      $.ajax({
        url: 'action.php',
        method: 'post',
        data: {
          pid: pid,
          pname: pname,
          pprice: pprice,
          pqty: pqty,
          pimage: pimage,
          pcode: pcode
        },
        success: function(response) {
          $("#message").html(response);
          window.scrollTo(0, 0);
          load_cart_item_number();
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
