<?php
session_start();

# Include file to connect to database.
require_once "../connect.php";

$code = "CB-";

# Checks the type of product selected and fetches the information about it for display.
if (isset($_POST['coffee-type'], $_POST['roast-type'], $_POST['size-type'])) {
  $code .= $_POST['coffee-type'] .= $_POST['roast-type'] .= $_POST['size-type'];

  $sql = "SELECT * FROM `inventory` WHERE `item_code` = '$code'";
  $stmt = $pdo->prepare($sql);
  if ($stmt->execute()) {
    $row = $stmt->fetch();
    $image = $row['item_img'];
    $name = $row['item_name'];
    $code = $row['item_code'];
    $type = $row['item_type'];
    $size = $row['item_size'];
    $price = $row['item_price'];
  }

  $cartArray = array(
    $code=>array(
    'image'=>$image,
    'name'=>$name,
    'type'=>$type,
    'size'=>$size,
    'code'=>$code,
    'price'=>$price,
    'quantity'=>$_POST['quantity'])
  );

  # Checks if the product needs to be added or has already been added in the cart.
  if(empty($_SESSION["shopping_cart"])) {
    $_SESSION["shopping_cart"] = $cartArray;
    $status = "<div class='box'>Product is added to your cart!</div>";
  }else {
    $array_keys = array_keys($_SESSION["shopping_cart"]);
    if(in_array($code,$array_keys)) {
      $status = "<div class='box' style='color:red;'>Product is already added to your cart!</div>";  
    } else {
      $_SESSION["shopping_cart"] = array_merge($_SESSION["shopping_cart"], $cartArray);
      $status = "<div class='box'>Product is added to your cart!</div>";
    }
  }
}

$status="";
$cart_count="0";

# Checks if the user removed any product from the shopping cart.
if (isset($_POST['action']) && $_POST['action']=="remove") {
  if(!empty($_SESSION["shopping_cart"])) {
    foreach($_SESSION["shopping_cart"] as $key => $value) {
      if($_POST["code"] == $key) {
        unset($_SESSION["shopping_cart"][$key]);
        $status = "<div class='box' style='color:red;'>Product is removed from your cart!</div>";
      }
      if(empty($_SESSION["shopping_cart"])) {
        unset($_SESSION["shopping_cart"]);
      }   
    }
  }
}

# Checks if the user changes the quantity and updates it.
if (isset($_POST['action']) && $_POST['action']=="change") {
  foreach($_SESSION["shopping_cart"] as &$value) {
    if($value['code'] === $_POST["code"]) {
      $value['quantity'] = $_POST["quantity"];
      # Stop the loop once we've found the product.
      break;
    }
  }
}

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

    <div class="cart">
    <?php
      if(isset($_SESSION["shopping_cart"])) {
        $total_price = 0;
    ?>  
      <table class="table">
      <tbody>
      <tr>
        <td></td>
        <td>ITEM NAME</td>
        <td>QUANTITY</td>
        <td>UNIT PRICE</td>
        <td>ITEMS TOTAL</td>
      </tr> 
      <?php   
        foreach ($_SESSION["shopping_cart"] as $product) {
      ?>
      <tr>
        <td><img src='<?php echo $product["image"]; ?>' width="50" height="40" /></td>
        <td><?php echo $product["name"].', '.$product["type"].', '.$product["size"]; ?><br />
          <form method='post' action=''>
            <input type='hidden' name='code' value="<?php echo $product["code"]; ?>" />
            <input type='hidden' name='action' value="remove" />
            <button type='submit' class='remove'>Remove Item</button>
          </form>
        </td>
        <td>
          <form method='post' action=''>
            <input type='hidden' name='code' value="<?php echo $product["code"]; ?>" />
            <input type='hidden' name='action' value="change" />
            <select name='quantity' class='quantity' onChange="this.form.submit()">
              <option <?php if($product["quantity"]==1) echo "selected";?> value="1">1</option>
              <option <?php if($product["quantity"]==2) echo "selected";?> value="2">2</option>
              <option <?php if($product["quantity"]==3) echo "selected";?> value="3">3</option>
              <option <?php if($product["quantity"]==4) echo "selected";?> value="4">4</option>
              <option <?php if($product["quantity"]==5) echo "selected";?> value="5">5</option>
              <option <?php if($product["quantity"]==6) echo "selected";?> value="6">6</option>
              <option <?php if($product["quantity"]==7) echo "selected";?> value="7">7</option>
              <option <?php if($product["quantity"]==8) echo "selected";?> value="8">8</option>
              <option <?php if($product["quantity"]==9) echo "selected";?> value="9">9</option>
              <option <?php if($product["quantity"]==10) echo "selected";?> value="10">10</option>
            </select>
          </form>
        </td>
        <td><?php echo "$".$product["price"]; ?></td>
        <td><?php echo "$".$product["price"]*$product["quantity"]; ?></td>
        </tr>
        <?php
            $total_price += ($product["price"]*$product["quantity"]);
          }
        ?>
        <tr>
          <td colspan="5" align="right"><strong>TOTAL: <?php echo "$".$total_price; ?></strong></td>
        </tr>
        <tr>
          <form action="placeorder.php" method="post">
            <td colspan="5" align="center"><button type='submit' name="checkout" class='btn'>Checkout</button></td>
          </form>
        </tr>

      </tbody>
      </table>    
      <?php
        } else {
            echo "<h3>Your cart is empty!</h3>";
          }
      ?>
  </div>

  <div style="clear:both;"></div>
  <div class="message_box" style="margin:10px 0px;">
    <?php echo '<div align="center">' .$status. '</div>'; ?>
  </div>

  </body>
</html>
