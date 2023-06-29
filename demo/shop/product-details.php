<?php
session_start();

# Include file to connect to database.
require_once "../connect.php";

$status="";
$cart_count="0";

$product = $_GET['prod'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="../images/coffeebean.png">
    <title>Coffee Beanz | <?php echo $_GET['prod']; ?></title>
    <link rel="stylesheet" href="../styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css">
  </head>
  <body>
    <div class="header">
      <div class="container">
        <div class="navbar">
          <div class="logo"></div>
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
  
    <!------ single product details ------>     
    <div class="small-container single-product">
      <div class="row">
	<div class="col-2">
	 <p><a href='products.php'>Products</a> / <?php print $product ?> Coffee Beans</p>
          <img src="../images/<?php echo $product.".JPG"; ?>" width="100%" id="productImg">
            <div class="small-img-row">
              <div class="small-img-col">
		<img src="../images/<?php echo $product."Drink.JPG"; ?>" width="100%" class="small-img">
		          </div>
		          <div class="small-img-col">
                <img src="../images/<?php echo $product."Drink-2.JPG"; ?>" width="100%" class="small-img">
			  </div>
			<div class="small-img-col">
                <img src="../images/<?php echo $product."Drink3.JPG"; ?>" width="100%" class="small-img">
			  </div>
			
               
		    
            </div>
        </div>
      
        <div class="products">
        <?php
          $product = $_GET['prod'];
          $sql = "SELECT * FROM `inventory` WHERE `item_name` = '$product'";
          $stmt = $pdo->prepare($sql);
          if ($stmt->execute()) {
            if($row = $stmt->fetch()) {
              echo "<div class='col-2'>
              
              <h1> $product Coffee beans</h1>
              <form name='order' action='cart.php' method='post'>";
              if ($product == "Arabica") {
                echo "<input type='hidden' name='coffee-type' value='A' />";
              } elseif ($product == "Excelsa") {
                echo "<input type='hidden' name='coffee-type' value='E' />";
              } else if ($product == "Liberica") {
                echo "<input type='hidden' name='coffee-type' value='L' />";
              } elseif ($product == "Robusta") {
                echo "<input type='hidden' name='coffee-type' value='R' />";
              }
              echo "<select name='roast-type'>
              <option value=''>Select Roast</option>
              <option value='L'>Light</option>
              <option value='M'>Medium</option>
              <option value='MD'>Medium-Dark</option>
              <option value='D'>Dark</option>
              </select>
              <select name='size-type'>
                <option value=''>Select Size</option>
                <option value='16'>16 oz</option>
                <option value='32'>32 oz</option>
              </select>
                
                <input type='number' name='quantity' value='1' min='1' max='10'>
		<input type='submit' name='add-item' class='btn' value='Add To Cart'> <br>
		<label2 for='quantity'><h5>Max Quantity: 10</h5></label22> <br>
              </form>";
            }
          }
          if ($product == "Arabica") {
            echo "<h3>Product Details <i class='fa fa-ident'></i></h3>
                  <p> * Strong black coffee with bold flavor but smooth whole bean coffee. Not bitter. Best Arabica whole bean coffee. <br> * Cupping notes: heavy body, smooth, cinnamon, and bright with a long finish.<br> <br> Different roast available: <br> * Light roast <br> * Medium roast <br> * Medium-Dark roast <br> * Dark roast </p>";
          } elseif ($product == "Excelsa") {
              echo "<h3>Product Details <i class='fa fa-ident'></i></h3>
                    <p> * Excelsa has a distinctive tart, fruity, dark, and mysterious taste.<br> * Middle and back palate and lingering finish of the coffee, giving the cup more substance and power.<br> * Brewed on its own, it is a compelling and unique coffee experience. <br> <br>  Different roast available: <br> * Light roast <br> * Medium roast <br> * Medium-Dark roast <br> * Dark roast</p>";
            } else if ($product == "Liberica") {
                echo "<h3>Product Details <i class='fa fa-ident'></i></h3>
                      <p> * Its almond-shaped beans have an exceptional aroma <br> * Almost floral and fruity, while its flavor is full and slightly smokey. <br> <br> Different roast available: <br> * Light roast <br> * Medium roast <br> * Medium-Dark roast <br> * Dark roast</p>";
              } elseif ($product == "Robusta") {
                  echo "<h3>Product Details <i class='fa fa-ident'></i></h3>
                        <p> * Chocolatey taste, very smooth <br> * Great for espresso by itself or blended with Arabica to increase crema. Used in many award-winning Italian espresso blends <br> * High caffeine, high body, low acid <br> * Back palate coffee appeals to coffee lovers who like persistance of taste and rich, dark flavor profile <br> * This is a highland-grown, Dalat Province, very select Robusta, quite different from lowland-grown Robustas <br> <br> Different roast available: <br> * Light roast <br> * Medium roast <br> * Medium-Dark roast <br> * Dark roast</p>";
                }
          unset($pdo);
        ?>
        </div>
      </div>
    </div>

    <script>
      var MenuItems = document.getElementById("MenuItems");
      MenuItems.style.maxHeight = "0px";

      function menutoggle() {
        if(MenuItems.style.maxHeight = "0px") {
          MenuItems.style.maxHeight = "200px"
        } else {
          MenuItems.style.maxHeight = "0px"
        }
    }
    </script>
    <script>
      var productImg = document.getElementById("productImg");
      var SmallImg = document.getElementsByClassName("small-img");
      SmallImg[0].onclick = function() {
        productImg.src = SmallImg[0].src;
      }
      SmallImg[1].onclick = function() {
        productImg.src = SmallImg[1].src;
      }
      SmallImg[2].onclick = function() {
        productImg.src = SmallImg[2].src;
      }
    </script>
    
  </body>
</html>
