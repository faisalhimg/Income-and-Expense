<?php
declare(strict_types=1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = trim($_POST["firstName"]);
    $lastName = trim($_POST["lastName"]);
    $username = trim($_POST["username"]);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $password = $_POST["password"];

    try {
        require_once 'dbh.inc.php';
        require_once 'signup_model.inc.php';
        require_once 'signup_contr.inc.php';
        
        // Error handling
        $errors = [];

        if (is_input_empty($firstName, $lastName, $username, $email, $password)) {
            $errors["empty_input"] = "Fill in all fields!";
        }
        if (is_email_invalid($email)) {
            $errors["invalid_email"] = "Invalid email format!";
        }
        if (is_username_taken($pdo, $username)) {
            $errors["username_taken"] = "Username already taken!";
        }
        if (is_email_registered($pdo, $email)) {
            $errors["email_used"] = "Email already registered!";
        }

        require_once 'config_session.inc.php';
        
        if ($errors) {
            $_SESSION['errors_signup'] = $errors;
            $_SESSION['signup_data'] = [
                'firstName' => $firstName,
                'lastName' => $lastName,
                'username' => $username,
                'email' => $email
            ];
            header("Location: ../signup.php");
            die();
        }

        // Create user
        create_user($pdo, $firstName, $lastName, $username, $email, $password);
        
        // Success - redirect to login
        header("Location: ../index.php?signup=success");

        $pdo = null;
        $stmt = null;
        die();

    } catch (PDOException $e) {
        die("Signup failed: " . $e->getMessage());
        header("Location: ../signup.php?error=database_error");
  
    }
} else {
    header("Location: ../signup.php");
    die();
}