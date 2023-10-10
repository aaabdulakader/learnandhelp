<!-- <?php
  $status = session_status();
  if ($status == PHP_SESSION_NONE) {
    session_start();
  }
 ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="icon" href="images/icon_logo.png" type="image/icon type">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;900&display=swap" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
  </head>
  <body>
  <?php include 'show-navbar.php'; ?>
  <?php show_navbar(); ?>
  <header class="inverse">
      <div class="container">
          <h1><span class="accent-text">Login</span></h1>
      </div>
  </header>
  <br>
  <form action="validate-login.php" method="post">
      <label for="usermail">Email</label>
      <br>
      <input id="usermail" type="email" name="usermail" placeholder="Yourname@email.com" required>
      <br>
      <label for="password">Password</label>
      <br>
      <input id="password" type="password" name="password" placeholder="Password" required>
      <br>
      <input type="submit" id="submit-login" value="Login"/>
	</form>
  <a href="create_account.php" id="create_account_button">Create Account</a>
  </body>
</html>
 -->
 <?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  $status = session_status();
  if ($status == PHP_SESSION_NONE) {
    session_start();
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/icon_logo.png" type="image/icon type">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;900&display=swap" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
  </head>
  <body>
    <?php 
      include_once 'show-navbar.php'; 
      if(function_exists('show_navbar')) {
        show_navbar(); 
      } else {
        echo "Function show_navbar() is not defined!";
      }
    ?>
    <header class="inverse">
      <div class="container">
        <h1><span class="accent-text">Login</span></h1>
      </div>
    </header>
    <br>
    <form action="validate-login.php" method="post">
      <label for="usermail">Email</label>
      <br>
      <input id="usermail" type="email" name="usermail" placeholder="Yourname@email.com" required>
      <br>
      <label for="password">Password</label>
      <br>
      <input id="password" type="password" name="password" placeholder="Password" required>
      <br>
      <input type="submit" id="submit-login" value="Login"/>
    </form>
    <a href="create_account.php" id="create_account_button">Create Account</a>

    <div class="forgot-password-form">
      <h2>Forgot Password</h2>
      <form id="resetPasswordForm">
        <label for="resetEmail">Email:</label>
        <input type="email" id="resetEmail" required>
        <button type="submit">Send Reset Link</button>
      </form>
    </div>

    <script>
      document.getElementById("resetPasswordForm").addEventListener("submit", function (e) {
        e.preventDefault();
        let email = document.getElementById("resetEmail").value;

        fetch("/api/requestPasswordReset", {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify({ email: email })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert("Reset link sent!");
          } else {
            alert("Error: " + data.message);
          }
        });
      });
    </script>
  </body>
</html>
