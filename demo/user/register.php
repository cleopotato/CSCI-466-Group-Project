<?php
  session_start();

  # Connect to the database.
  require_once "../connect.php";

  $status="";
  $cart_count="0";

  # Define variables and initialize to empty.
  $username = $password = $confirm_password = "";
  $username_err = $password_err = $confirm_password_err = "";
 
  # Processes form data when form is submitted.
  if($_SERVER["REQUEST_METHOD"] == "POST") {
 
    # Validates username.
    if(empty(trim($_POST["username"]))) {
      $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        $username_err = "Username can only contain letters, numbers, and underscores.";
      } else {
        # Prepare a select statement.
        $sql = "SELECT id FROM users WHERE username = :username";
        
        if($stmt = $pdo->prepare($sql)) {
          # Bind variables to the prepared statement as parameters.
          $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            
          # Sets parameters.
          $param_username = trim($_POST["username"]);
            
          # Attempts to execute the prepared statement.
          if($stmt->execute()) {
            if($stmt->rowCount() == 1) {
              $username_err = "This username is already taken.";
            } else {
                $username = trim($_POST["username"]);
              }
          } else {
              echo "Oops! Something went wrong. Please try again later.";
            }

            # Closes the statement.
            unset($stmt);
        }
      }
    
    # Validates password entered.
    if(empty(trim($_POST["password"]))) {
      $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have atleast 6 characters.";
      } else {
          $password = trim($_POST["password"]);
        }
    
    # Validates confirm password.
    if(empty(trim($_POST["confirm_password"]))) {
      $confirm_password_err = "Please confirm password.";     
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)) {
          $confirm_password_err = "Password did not match.";
        }
      }
    
    # Check for input errors before inserting in database.
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
      # Prepare an insert statement.
      $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
         
      if($stmt = $pdo->prepare($sql)) {
        # Bind variables to the prepared statement as parameters.
        $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
        $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            
        # Sets parameters.
        $param_username = $username;
        # Creates a password hash to ensure each is unique.
        $param_password = password_hash($password, PASSWORD_DEFAULT);
            
        # Attempts to execute the prepared statement.
        if($stmt->execute()) {
          # Redirects to the user login page.
          header("location: ../user/login.php");
        } else {
            echo "Oops! Something went wrong. Please try again later.";
          }

          # Closes the statement.
          unset($stmt);
      }
    }

    # Closes the connection to database.
    unset($pdo);
  }
?>
 
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="../images/coffeebean.png">
    <title>Coffee Beanz | Register</title>
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
    <div class="wrapper">
      <h2>Sign Up</h2>
      <p>Please fill this form to create an account.</p>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
          <label>Username</label>
          <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" 
          value="<?php echo $username; ?>">
          <span class="invalid-feedback"><?php echo $username_err; ?></span>
        </div>    
        <div class="form-group">
          <label>Password</label>
          <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
          <span class="invalid-feedback"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group">
          <label>Confirm Password</label>
          <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
          <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
        </div>
        <div class="form-group">
          <input type="submit" class="button" value="Submit">
          <input type="reset"  class="button" value="Reset">
        </div>
        <p>Already have an account? <a href="../user/login.php">Login here</a>.</p>
      </form>
    </div>    
  </body>
</html>