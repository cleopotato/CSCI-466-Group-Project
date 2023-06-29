<?php
  session_start();

  # Include file to connect to database.
  require_once "../connect.php";

  $status="";
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
   
    <div class="small-container">
      <div class="row row-2">
        <h2>All Products<h2>
        <select>
          <option>Default Sorting</option>
          <option>Sort by price</option>
        </select>
      </div>
      <div class="row">
        <div class="col-4">
        <img src="../images/Arabica.JPG">
        <a href="product-details.php?prod=Arabica">Arabica Coffeee Beans</a>
        <p>$19.99-$25.99</p>
      </div>
      <div class="col-4">
        <img src="../images/Excelsa.JPG">
        <a href="product-details.php?prod=Excelsa">Excelsa Coffeee Beans</a>

        <p>$17.99-$22.99</p>
      </div>
      <div class="col-4">
        <img src="../images/Liberica.JPG">
        <a href="product-details.php?prod=Liberica">Liberica Coffeee Beans</a>
        <p>$22.99-$28.99</p>
      </div>
      <div class="col-4">
        <img src="../images/Robusta.JPG">
        <a href="product-details.php?prod=Robusta">Robusta Coffeee Beans</a>
        <p>$24.99-$30.99</p>
      </div>
    </div>

  </body>
</html>