<?php
  # Initialize the session.
  session_start();
  $cart_count="0";
 
  # Check if the user is already logged in, if yes then redirect to user dashboard page.
  if(isset($_SESSION["user_loggedin"]) && $_SESSION["user_loggedin"] == true) {
    header("location: ../user/dashboard.php");
    exit;
  }
 
  # Include file to connect to database.
  require_once "../connect.php";
 
  # Define variables and initialize to empty.
  $username = $password = "";
  $username_err = $password_err = $login_err = "";
 
  # Processes form data when form is submitted.
  if($_SERVER["REQUEST_METHOD"] == "POST") {
 
    # Check if username is empty.
    if(empty(trim($_POST["username"]))) {
      $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
      }
    
    # Check if password is empty.
    if(empty(trim($_POST["password"]))) {
      $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
      }
    
    # Validate credentials.
    if(empty($username_err) && empty($password_err)) {
      # Prepare a select statement.
      $sql = "SELECT id, username, password FROM users WHERE username = :username";
        
      if($stmt = $pdo->prepare($sql)) {
        # Bind variables to the prepared statement as parameters.
        $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            
        # Set parameters.
        $param_username = trim($_POST["username"]);
            
        # Attempt to execute the prepared statement.
        if($stmt->execute()) {
          # Check if username exists, if yes then verify password.
          if($stmt->rowCount() == 1) {
            if($row = $stmt->fetch()) {
              $id = $row["id"];
              $username = $row["username"];
              $hashed_password = $row["password"];
              if(password_verify($password, $hashed_password)) {
              # Password is correct, so start a new session.
              session_start();
                            
              # Store data in session variables.
              $_SESSION["user_loggedin"] = true;
              $_SESSION["user_id"] = $id;
              $_SESSION["user_name"] = $username;                            
                            
              # Redirect user to welcome page.
              header("location: ../user/dashboard.php");
              } else {
                  # Password is not valid, display a generic error message.
                  $login_err = "Invalid username or password.";
                }
            }
          } else {
              # Username doesn't exist, display a generic error message.
              $login_err = "Invalid username or password.";
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
          }

        # Close statement.
        unset($stmt);
      }
    }
    
    # Close connection.
    unset($pdo);
  }
?>
 
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="../images/coffeebean.png">
    <title>Coffee Beanz | User Login</title>
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
      <h2>Login</h2>
      <p>Please fill in your credentials to login.</p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
            <span class="invalid-feedback"><?php echo $username_err; ?></span>
          </div>    
          <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
            <span class="invalid-feedback"><?php echo $password_err; ?></span>
          </div>
          <div class="form-group">
            <input type="submit" class="button" value="Login">
            <input type="reset"  class="button" value="Reset">
          </div>
          <p>Don't have an account? <a href="../user/register.php">Sign up now</a>.</p>
          <p>No time to sign up? <a href="../user/trackorder.php">Track my order(s)</a>.</p>
        </form>
    </div>
  </body>
</html>

