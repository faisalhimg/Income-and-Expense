<?php
require_once 'includes/config_session.inc.php';

if (isset($_SESSION["user_id"])) {
   header("Location: dashboard.php");
   exit();
}

require_once 'includes/signup_view.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Sign up for GIGWorks Income and Expense Tracker">
  <title>Sign Up | GIGWorks Income & Expenses</title>
  <link rel="stylesheet" href="includes/styles.login.css">
  
</head>
<body>
  <main class="container">
    <header class="header" role="banner">
      <h1>GIG INCOME AND EXPENSES</h1>
      <p class="tagline">Track your freelance finances with ease</p>
    </header>

    <section class="form-section" aria-labelledby="signup-heading">
      <div class="form-wrapper">
        <h2 id="signup-heading">Create Your Account</h2>
        
        <form id="signup-form" method="post" action="includes/signup.inc.php">

          <?php 
          signup_input(); //import form from signup
          ?>
          
            <p class="hint">Minimum 8 characters</p>
          </div>

          <button type="submit" class="btn">
            <span>Sign Up</span>
            <span aria-hidden="true">→</span>
          </button>
        </form>
        

        <p class="login-redirect">
          Already have an account? <a href="index.php">Log in</a>
        </p>
        <p><?php
  check_signup_error(); //use view to write this function since we are going to output information on the webpage to the user
  ?> </P>
      </div>
    </section>
  </main>

</body>
</html>