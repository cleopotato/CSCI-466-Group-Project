<?php
  # Initializes the session.
  session_start();

  $cart_count = 0;
  
  # Check if the employee is logged in, if not then redirect to employee login page.
  if(!isset($_SESSION["employee_loggedin"]) || $_SESSION["employee_loggedin"] != true) {
    header("location: ../employee/login.php");
    exit;
  }

  # Include file to connect to database.
  require_once "../connect.php";
  
?>
 
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="../images/coffeebean.png">
    <title>Coffee Beanz | Employee Login</title>
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
            <img scr="../images/menu.png" class="menu-icon" onclick="menutoggle()">
          </nav>
            
        </div>
      </div>
    </div>
    <h1 class="prompt">Hello, <b><?php echo htmlspecialchars($_SESSION["employee_username"]); ?></b>. Let's get to work!.</h1>

    <!-- Enter employee information -->
    <h3>Enter Employee Information</h3>
      <form method="POST">
        <div class="form-group">
          <label for="info">Enter your name:</label>
          <input type="text" id="info" name="n" class="form-control" placeholder="Ariana Grande">
        </div>
        <div class="form-group">
          <label for="info">Enter your home address:</label>
          <input type="text" id="info" name="address" class="form-control" placeholder="123 Bean Road">
        </div>
        <div class="form-group">
          <label for="info">Enter your e-mail:</label>
          <input type="text" id="info" name="email" class="form-control" placeholder="ilovecoffee@gmail.com">
        </div>
        <div class="form-group">
          <label for="info">Enter your phone number:</label>
          <input type="text" id="info" name="phone" class="form-control" placeholder="2241231234">
        </div>
          <input type="submit" value="Update" name="valid" class="logout-btn">
        </form>

    <?php
      if(isset($_POST['valid'])) 
      {
        $empname = $_POST['n'];
        $empadd = $_POST['address'];
        $empemail = $_POST['email'];
        $empphone = $_POST['phone'];
        $user = $_SESSION["employee_username"];
    
    $sql = "UPDATE employees SET name = '$empname', address = '$empadd', email = '$empemail', phone = '$empphone' WHERE username = '$user'";
      try
      {
        $statement = $pdo->prepare($sql);
        $result = $statement->execute();
        if($result) {
          echo "New employee information added.";
        }
        else {
          echo "Could not validate new employee information.";
        }
      } 
      catch (PDOException $e)
      {
        echo "Couldn't insert new values to employees. Query failed due to PDO Exception with message: " . $e->getMessage();
      }
    }
?>

    <!-- View current inventory -->
    <h3>View current inventory</h3><br>
    <form method = "POST">
      <input type="submit" class="logout-btn" value="View Inventory" name="view-inv">
    </form>

    <?php
    if(isset($_POST['view-inv']))
    {
      $sql = 'SELECT item_id, item_code, item_name, item_type, item_size, item_price, item_qty FROM inventory;';
    try
    { // if something goes wrong, an exception is thrown
      //query to retrieve data from Suppliers and function to draw table
      $rs = $pdo->query($sql);
      $rows = ($rs->fetchAll(PDO::FETCH_ASSOC));
      draw_table($rows);
    }
    catch(PDOException $e)
    {
      echo "Couldn't retrieve list of product. Query failed due to PDO Exception with message: " . $e->getMessage();
    }
    }
    ?>

    
    <h3>Showing all processing orders</h3> 
    <br>
    <form method = "POST">
      <input type="submit" class="logout-btn" value="View Orders" name="view-ord">
    </form>

    <?php
    if(isset($_POST['view-ord']))
    {
      $sql = 'SELECT * FROM orders;';
    try
    { // if something goes wrong, an exception is thrown
      //query to retrieve data from Suppliers and function to draw table
      $rs = $pdo->query($sql);
      $rows = ($rs->fetchAll(PDO::FETCH_ASSOC));
      draw_table($rows);
    }
    catch(PDOException $e)
    {
      echo "Couldn't retrieve list of product. Query failed due to PDO Exception with message: " . $e->getMessage();
    }
    }
    ?>

    <h3>Processing Orders</h3> <!-- Takes data from past tables, into foreign key, employee enters information and creates a new table with shipped status and tracking-->
    <form method="POST">
      <label for="order_id">Please Enter the Order ID to update:</label>
      <input type="text" id="order_id" name="Order_ID" placeholder="Order ID"> 
      <br>
      <label for="order_status">Please Enter if Order has been Shipped:</label>
      <input type="text" id="order_status" name="Order_Status" placeholder="Shipped / Processing"> 
      <br>
      <input type="submit" value="Submit" name="process">
    </form>

    <?php
    //id = real name, name = fake
    if(isset($_POST['process']))
    {
        $Order_ID = $_POST['Order_ID'];
        $Order_Status = $_POST['Order_Status'];
        
        $sql = "UPDATE orders SET order_status = '$Order_Status' WHERE order_id = '$Order_ID'";
    
        try
        {
            $statement = $pdo->prepare($sql);
            $result = $statement->execute(array($Order_Status));
                if($result)
                {
                    echo "Order has Been Successfully Updated!";
                }
                else
                {
                    echo "Failed to Update Order!";
                }
        }
        catch(PDOException $e)
        {
            echo "Couldn't Update Customer's Order. Query failed due to PDO Exception with message: " . $e->getMessage();
        }
    }
    ?>

    <p>
      <a href="../employee/logout.php" class="logout-btn">Sign Out</a>
    </p>


  </body>
</html>