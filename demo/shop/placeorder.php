<?php
session_start();

# Include file to connect to database.
require_once "../connect.php";

$user = "";

ob_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="../images/coffeebean.png">
    <title>Coffee Beanz | All Products</title>
    <link rel="stylesheet" href="../styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body>
    <div class="header">
      <div class="container">
        <div class="logo"></div>
          <div class="navbar">
            <nav>
              <ul id="MenuItems">
                <li><a href="../index.html">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="../contact.php">Contact</a></li>
                <li><a href="../employee/login.php">Employee</a></li>
                <li><a href="../user/login.php">Account</a></li>
              </ul>
              <?php
                if(!empty($_SESSION["shopping_cart"])) {
                  $cart_count = count(array_keys($_SESSION["shopping_cart"]));
              ?>
              <?php
                }
              ?>
              <div class="cart_div">
                <a href="cart.php"><img src="../images/cart.png" /><span><?php echo $cart_count; ?></span></a>
              </div>
              <img scr="../images/menu.png" class="menu-icon" onclick="menutoggle()">
            </nav>
          </div>
      </div>
    </div>

    <div class="row">
    <div class="col-75">
      <div class="container">

        <form action="" method="post">
          <div class="row">
            <div class="col-50">
              <h3>Checkout Information</h3>
              <label for="fname"><i class="fa fa-user"></i> Full Name</label>
              <input type="text" id="fname" name="fullname" placeholder="Jane Doe"><br>
              <label for="email"><i class="fa fa-envelope"></i> Email</label>
              <input type="text" id="email" name="email" placeholder="jane@example.com"><br>
              <label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
              <input type="text" id="adr" name="address" placeholder="123 W. Street Rd"><br>
              <label for="city"><i class="fa fa-institution"></i> City</label>
              <input type="text" id="city" name="city" placeholder="Chicago"><br>

              <div class="row">
                <div class="col-50">
                  <label for="state">State</label>
                  <input type="text" id="state" name="state" placeholder="IL">
                </div>
                <div class="col-50">
                  <label for="zip">Zip</label>
                  <input type="text" id="zip" name="zip" placeholder="00000">
                </div>
              </div>

	    </div>
<br>
	    <div class="col-50">

              <h3>Payment</h3>
              <label for="fname">Accepted Cards</label>
              <div class="icon-container">
                <i class="fa fa-cc-visa" style="color:navy;"></i>
                <i class="fa fa-cc-amex" style="color:blue;"></i>
                <i class="fa fa-cc-mastercard" style="color:red;"></i>
                <i class="fa fa-cc-discover" style="color:orange;"></i>
              </div>
              <label for="cname">Name on Card</label>
              <input type="text" id="cname" name="cardname" placeholder="Jane Doe"><br>
              <label for="ccnum">Credit card number</label>
              <input type="text" id="ccnum" name="cardnumber" placeholder="1111222233334444"><br>
              <label for="expmonth">Exp Month</label>
              <input type="text" id="expmonth" name="expmonth" placeholder="September"><br>

              <div class="row">
                <div class="col-50">
                  <label for="expyear">Exp Year</label>
                  <input type="text" id="expyear" name="expyear" placeholder="2018">
                </div>
                <div class="col-50">
                  <label for="cvv">CVV</label>
                  <input type="text" id="cvv" name="cvv" placeholder="352">
                </div>
              </div>
            </div>
          </div>
          
          <label>
          	<input type="checkbox" checked="checked" name="sameadr"> Shipping address same as billing
          </label><br>
          <button type='submit' name="placeorder" class='btn'>Place Order</button>
        </form>

    </div>
    </div>

    <div class="col-25">
    	<div class="container">
      	<h4>Cart<span class="price" style="color:black"><i class="fa fa-shopping-cart"></i> <b><?php echo $cart_count; ?></b></span></h4>
      	<?php
      		if(isset($_SESSION["shopping_cart"])) {
        		$total_price = 0; 
        		foreach ($_SESSION["shopping_cart"] as $product) {
      	?>
      	<p>
      		<?php echo $product["name"].', '.$product["type"].', '.$product["size"]; ?>
      		<span class="price"><?php echo "$".$product["price"]; ?></span>
      	</p>
      	<?php
          $total_price += ($product["price"]*$product["quantity"]);
        }
        }
      	?>
      	<hr>
      	<p>Total <span class="price" style="color:black"><b><?php echo "$".$total_price; ?></b></span></p>
    	</div>
  	</div>
  	</div>
    <?php
      if (!empty($_SESSION["user_name"])) {
        $user = $_SESSION["user_name"];
      }
    ?>

  	<?php
  		if (isset($_POST['placeorder'])) {
  			$name = $_POST['fullname'];
  			$email = $_POST['email'];
  			$address = $_POST['address'].' '.$_POST['city'].', '.$_POST['state'].' '.$_POST['zip'];
  			$billing = $_POST['cardname'].'-'.$_POST['cardnumber'].'-'.$_POST['expmonth'].'-'.$_POST['expyear'].'-'.$_POST['cvv'];
  			$status = "Processing";
  			
  			$sql = "INSERT INTO orders (cust_id, cust_name, cust_email, cust_address, cust_billing, order_code, order_qty, order_total, order_status)
  							VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
  			$stmt = $pdo->prepare($sql);
  			foreach($_SESSION["shopping_cart"] as $product) {
  				$result = $stmt->execute(array($user, $name, $email, $address, $billing, $product["code"], $product["quantity"], ($product["price"]*$product["quantity"]), $status));
  			}
  			if ($result) {
  				header("location: confirmation.php");
  			}
  		}
  	?>

  </body>
</html>
