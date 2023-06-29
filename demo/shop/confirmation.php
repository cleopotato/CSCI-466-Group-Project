<?php
session_start();

# Include file to connect to database.
require_once "../connect.php";

$cart_count="0";

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

    <div class="placeorder content-wrapper">
      <h1 style="text-align:center;">Your Order Has Been Placed</h1>
      <p style="text-align:center;">Thank you for ordering with us, we'll contact you by email with your order details.</p>
    </div>

    <?php
      # Check if the user is logged in, if not then redirect dashboard and unset the shopping cart.
      if(isset($_SESSION["user_loggedin"])) {
        unset($_SESSION["shopping_cart"]);
        exit;
      } else {
        session_destroy();
      }
    ?>
    
  </body>
</html>
