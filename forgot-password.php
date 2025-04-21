<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Reset your GIGWorks password">
  <title>Password Recovery | GIGWorks Income & Expenses</title>
  <link rel="stylesheet" href="includes/styles.login.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
  <main class="container">
    <header class="header" role="banner">
      <h1>GIG INCOME AND EXPENSES</h1>
      <p class="tagline">Reset your password</p>
    </header>

    <section class="form-section" aria-labelledby="recovery-heading">
      <div class="form-wrapper">
        <h2 id="recovery-heading">Password Recovery</h2>
        <p class="instruction-text">Enter your email address and we'll send you a link to reset your password.</p>
        
        <form id="recovery-form" method="post" action="process_recovery.php" novalidate>
          <div class="form-group">
            <label for="recovery-email">Email Address</label>
            <input 
              type="email" 
              id="recovery-email" 
              name="email" 
              placeholder="your@email.com" 
              required
              aria-required="true"
              autocomplete="email"
            >
          </div>

          <button type="submit" class="btn">
            <span>Send Reset Link</span>
          </button>

          <div class="form-footer">
            <p>Remember your password? <a href="index.php">Return to login</a></p>
            <p class="support-text">Need help? <a href="contact.html">Contact support</a></p>
          </div>
        </form>
      </div>
    </section>
  </main>

  <div class="notification-toast" aria-live="polite" role="status"></div>

</body>
</html>