<?php
  # Initialize the session.
  session_start();

  $cart_count = 0;
 
  # Check if the user is logged in, if not then redirect to login page.
  if(!isset($_SESSION["user_loggedin"]) || $_SESSION["user_loggedin"] != true) {
    header("location: ../user/login.php");
    exit;
  }

  $user_id = $_SESSION["user_id"];

  # Include file to connect to database.
  require_once "../connect.php";
  
  $status = False;
  $success_msg = "";
  $failed_msg = "";
  if(isset($_POST['valid'])) 
  {
    $usrname = $_POST['n'];
    $usradd = $_POST['address'];
    $usremail = $_POST['email'];
    $usrphone = $_POST['phone'];
    $user = $_SESSION["user_name"];
    
    $sql = "UPDATE users SET name = '$usrname', address = '$usradd', email = '$usremail', phone = '$usrphone' WHERE username = '$user'";
    try
    {
      $statement = $pdo->prepare($sql);
      $result = $statement->execute();
      if($result) {
        $status = True;
        $success_msg = "User information successfully updated.";
      } else {
        $failed_msg = "Unable to validate user information.";
        }
    } 
    catch (PDOException $e)
    {
        $error_msg = "Couldn't insert new values to 'users'. Query failed due to PDO Exception with message: " . $e->getMessage();
    }
  }           
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

    <h1 class="prompt" style="text-align:center;">Hello, <b><?php echo htmlspecialchars($_SESSION["user_name"]); ?></b>. Welcome to our site.</h1>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
      <input type="submit" name="ad-btn" class="user-btn" value="Account Details"><br>
      <input type="submit" name="ud-btn" class="user-btn" value="Update Details"><br>
      <input type="submit" name="ao-btn" class="user-btn" value="Account Orders">
    </form>

    <div class="accnt-details-res">
    <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['ad-btn'])) {
          ## NEED TO ADD EDIT BUTTON TO EDIT ACCOUNT INFO ##
          $sql = "SELECT name, address, email, phone FROM users WHERE id = $user_id";
          $stmt = $pdo->prepare($sql);

          if ($stmt->execute()) {
            if ($stmt->rowCount() == 1) {
              if ($row = $stmt->fetch()) {
                echo "<h3>Account Details</h3>";
                echo "Name: " . $row["name"] . "</br>";
                echo "Address: " . $row["address"] . "</br>";
                echo "Email: " . $row["email"] . "</br>";
                echo "Phone: " . $row["phone"] . "</br>";
              }
            }
          }
        } elseif(isset($_POST['ud-btn'])) {
            echo "<!-- Enter employee information -->
                  <h3 style='text-align:center;'>Update User Information</h3>
                  <form method='POST'>
                  <section class='other'> 
                  <p>
                    <label for='info'>Enter your name:</label>
                    <input type='text' id='info' name='n' class='form-control' placeholder='Ariana Grande'>
                  </p>
                  <p>
                    <label for='info'>Enter your home address:</label>
                    <input type='text' id='info' name='address' class='form-control' placeholder='123 Bean Road'>
                  </p>
                  <p>
                    <label for='info'>Enter your e-mail:</label>
                    <input type='text' id='info' name='email' class='form-control' placeholder='ilovecoffee@gmail.com'>
                  </p>
                  <p>
                    <label for='info'>Enter your phone number:</label>
                    <input type='text' id='info' name='phone' class='form-control' placeholder='2241231234'>
                  </p>
                  <br>
                    <input type='submit' value='Update' name='valid' class='user-btn'>
                  </form>
                  </section>";
          } elseif (isset($_POST['ao-btn'])) {
            #echo "This is the account order button.";

            $user = $_SESSION["user_name"];

            $sql = $sql = "SELECT cust_name, cust_address, order_code, order_qty, order_total, order_status FROM orders WHERE cust_id = '$user'";
            try
            { // if something goes wrong, an exception is thrown
              //query to retrieve data from orders table and function to draw table
              $rs = $pdo->query($sql);
              $rows = ($rs->fetchAll(PDO::FETCH_ASSOC));
              echo "<table class='center'>";
              draw_table($rows);
              echo "</table>";
              #draw_table($rows);
            }
            catch(PDOException $e)
            {
              echo "Couldn't retrieve list of orders. Query failed due to PDO Exception with message: " . $e->getMessage();
            }
          }
      }
      if ($status == true) {
        echo $success_msg;
      } else {
        echo $failed_msg;
      }
    ?>
    </div>

    <p>
      <a href="../user/logout.php" class="user-btn">Sign Out</a>
    </p>
    
  </body>
</html>