<?php
  # Initialize the session.
  session_start();
  $cart_count="0";

  # Include file to connect to database.
  include "../connect.php";

  # Define variables and initialize to empty.
  $name_email = "";
  $search_error = "";
  
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="../images/coffeebean.png">
    <title>Coffee Beanz | My Account</title>
    <link rel="stylesheet" href="../styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css">
  </head>
  <body>
    <!------ Menu ------>
    <div class="header">
      <div class="container">
        <div class="logo"></div>
        <div class="navbar">
          <nav>
            <ul id="MenuItems">
            <li><a href="../index.html">Home</a></li>
            <li><a href="../shop/products.php">Products</a></li>
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
              <a href="../shop/cart.php"><img src="../images/cart.png" /><span><?php echo $cart_count; ?></span></a>
            </div>
            <img scr="images/menu.png" class="menu-icon" onclick="menutoggle()">
          </nav>   
        </div>
      </div>
    </div>

    <div class="wrapper">
      <h2><strong>Order Tracker</strong></h2>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
          <label>Enter Name or Email:</label>
          <input type="text" name="name-email" value="" placeholder="name or email">
          <span class="invalid-feedback"><?php echo $search_error; ?></span>
        </div>
        <div class="form-group">
          <input type="submit" class="button" value="Search">
          <input type="reset"  class="button" value="Reset">
        </div>
      </form>
    </div>
  
    <?php 
      # Processes form data when form is submitted.
      if ($_SERVER["REQUEST_METHOD"] == "POST") {

      # Check if field is empty.
      if(empty(trim($_POST["name-email"]))) {
        $search_error = "Please enter a name or email associated with the order.";
      } else {
        $name_email = trim($_POST["name-email"]);
        }

      # Validate credentials.
      if (empty($search_error)) {
        # Prepare a select statement.
        $sql = "SELECT order_code, order_qty, order_total, order_status FROM orders WHERE cust_name = '$name_email' OR cust_email = '$name_email'";
        $rs = $pdo->prepare($sql);
        if ($rs->execute()) {
          $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
          echo "<table class='center'>";
          draw_table($rows);
          echo "</table>";
        } else {
          # credentials doesn't exist, display a generic error message.
          $search_error = "No results found.";
          }
        }
      }
    ?>

  </body>
</html>