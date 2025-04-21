<?php



//NO1 check if the user legitmately used the signup form and not the url to access our site
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    //no3 the try will run the code to handle the catching of the erros and if there are no errors then login the user
    try {
        require_once 'dbh.inc.php';
        require_once 'signin_model.inc.php';
        require_once 'signin_contr.inc.php';
        
        // NO4 Error handling
        $errors = [];
 //next go to model view to make connection to query the database
        if (is_input_empty($username, $password)) {
            $errors["empty_input"] = "Fill in all fields!";
        }
//import the function from signin model
        $result = get_user ($pdo, $username);
//grab the errors into $error array

if (!$result || is_password_wrong($password, $result["password"])) {
    $errors["login_incorrect"] = "Incorrect username or password!";
}

        require_once 'config_session.inc.php';
        
        if ($errors) {
            $_SESSION['errors_login'] = $errors;
            
            header("Location: ../index.php");
            die();
        }
        
        //NO9 create new session and add user name to it. Next, go to config session to append user id to the regenerate session id
        $newSessionId = session_create_id();
        $sessionId = $newSessionId . "_" . $result["userID"];
        session_id($sessionId);


        //NO11 now sign in the user htmlspecialchars since username will be displayed inside the webpage
        $_SESSION["user_id"] = $result["userID"];
        $_SESSION["user_username"] = htmlspecialchars($result["username"]);

        $_SESSION["last_regeneration"] = time();

        header("Location: ../dashboard.php?login.success");

        $pdo = null;
        $statement = null;
        die();
    } catch (PDOException $e) {
            die("Signup failed: " . $e->getMessage());    
        }

} 
else { //if the user didn't submit a request method called post, kill the script and send the user back to the index page.
    header("Location: ../index.php"); //no2
    die();
}

