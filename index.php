<?php
require_once 'includes/config_session.inc.php';
if (isset($_SESSION["user_id"])) {
   header("Location: dashboard.php");
   exit();
}

require_once 'includes/signin_view.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Login to your GIGWorks Income and Expense Tracker">
  <title>Login | GIGWorks Income & Expenses</title>
  <link rel="stylesheet" href="includes/styles.login.css">

</head>
<body>
  <main class="container">
    <header class="header" role="banner">
      <h1>GIG INCOME AND EXPENSE</h1>
      <p class="tagline">Manage your freelance finances</p>
    </header>

    <section class="form-section" aria-labelledby="login-heading">
      <div class="form-wrapper">
        <h2 id="login-heading">Welcome Back</h2>
<form id="login-form" method="post" action="includes/signin.inc.php">
<div class="form-group">
    <label for="username">User Name</label>
    <input 
      type="text" 
      id="userName" 
      name="username" 
      placeholder="johndoe" 
      aria-required="true"
      autocomplete="family-name"
      
    >
  </div>

  <div class="form-group">
    <label for="login-password">Password</label>
    <input 
      type="password" 
      id="login-password" 
      name="password" 
      placeholder="Enter your password" 
      required
      aria-required="true"
      autocomplete="current-password"
    >
    <div class="password-actions">
      <label class="show-password">
        <input type="checkbox" id="show-password"> Show password
      </label>
      <a href="forgot-password.php" class="forgot-password">Forgot password?</a>
    </div>
  </div>

  <button type="submit" class="btn">
    <span>Log In</span>
  </button>

  <div class="form-footer">
  <?php check_signin_error(); ?>
    <p>Don't have an account? <a href="signup.php">Sign up</a></p>
  </div>
</form>


      </div>
    </section>
  </main>

</body>
</html>