<?php
session_start();
$cart_count="0";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="images/coffeebean.png">
    <title>All Products - Coffee Beanz | Contact Us</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css" integrity="sha512-rqQltXRuHxtPWhktpAZxLHUVJ3Eombn3hvk9PHjV/N5DMUYnzKPC1i3ub0mEXgFzsaZNeJcoE0YHq0j/GFsdGg==" crossorigin="anonymous" referrerpolicy="no-referrer">
  </head>
  <body>
    <div class="header">
      <div class="container">
        <div class="logo"></div>
        <div class="navbar">
          <nav>
            <ul id="MenuItems">
            <li><a href="index.html">Home</a></li>
            <li><a href="shop/products.php">Products</a></li>
            <li><a href="contact.php">Contact</a></li>
		        <li><a href="employee/login.php">Employee</a></li>
            <li><a href="user/login.php">Account</a></li>
            </ul>
            <?php
              if(!empty($_SESSION["shopping_cart"])) {
              $cart_count = count(array_keys($_SESSION["shopping_cart"]));
            ?>
            <?php
              }
            ?>
            <div class="cart_div">
              <a href="shop/cart.php"><img src="images/cart.png" /><span><?php echo $cart_count; ?></span></a>
            </div>
            <center><img scr="images/menu.png" class="menu-icon" onclick="menutoggle()"></center>
          </nav>
        </div>
      </div>
    

      <div class="row">
        <div class="col-5"></div>
          <div class="content">
            <h1>Contact Us</h1>
          </div>

          <div class="container-3">
            <div class="contactInfo">
              <div class="box">
                <div class="icon"><i class="fa fa-map" aria-hidden="true"></i></div>
                  <div class="text">
                    <h3>Address</h3>
                    <p>1045 Mitchell Road,<br>Chicago,IL,<br>60127</p>
                  </div>
              </div>
              <div class="box">
                <div class="icon"><i class="fa fa-mobile" aria-hidden="true"></i></div>
                  <div class="text">
                    <h3>Phone</h3>
                      <p>133-685-1900</p>
                  </div>
              </div>
              <div class="box">
                <div class="icon"><i class="fa fa-envelope" aria-hidden="true"></i></div>
                  <div class="text">
                    <h3>Email</h3>
                    <p>CoffeeBeanz@outlook.com</p>
                  </div>
              </div>
            </div>

            <div class="contactForm">
              <form>
                <h2>Send Message</h2>
                <div class="inputBox">
			           <input type="text" name="" required="required" placeholder="Full Name">
                </div>
                <div class="inputBox">
                  <input type="text" name="" required="required" placeholder="Email">
                </div>
                <div class="inputBox">
                  <textarea required="required" placeholder="Type your message here..."></textarea>
                </div>
                <div class="inputBox">
                  <input type="submit" name="send" value="send">
                </div>
              </form>
            </div>
          </div>
      </div>
    </div>

  <script>
    var MenuItems = document.getElementById("MenuItems");
    MenuItems.style.maxHeight = "0px";

    function menutoggle() {
      if(MenuItems.style.maxHeight = "0px") {
        MenuItems.style.maxHeight = "200px"
      }
      else
      {
        MenuItems.style.maxHeight = "0px"
      }
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
  </body>
</html>

