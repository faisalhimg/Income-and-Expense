<?php
if (session_status() === PHP_SESSION_NONE) {

    // Set session ini settings BEFORE starting session
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_httponly', 1);
    ini_set('session.cookie_secure', 0); // Change to 1 if using HTTPS

    // Set session cookie parameters
    session_set_cookie_params([
        'lifetime' => 1800,            // 30-minute session
        'domain' => 'localhost',       // Localhost (adjust in prod)
        'path' => '/',
        'secure' => false,             // Change to true for HTTPS
        'httponly' => true,
        'samesite' => 'Lax'            // Optional: improves security
    ]);

    session_start(); // NOW it's safe to start
}


//NO10 $user_id will be created when the user is login. else if the user is not login
if (isset($_SESSION["user_id"])) {
    if(!isset($_SESSION["last_regeneration"])){
        regenerate_session_id_loggedin();
    } else {
        $interval = 60 * 30;
        if (time() - $_SESSION["last_regeneration"] >=$interval){
            regenerate_session_id_loggedin();  //function to regenerate session id
        }
    }
} else {
//if condition which will run and update every 30mins to regenerate the cookies from prevent attackers from using the cookies

//isset function to check if this session exist inside the website ('!' means not exist)

if(!isset($_SESSION["last_regeneration"])){
    regenerate_session_id(); //function to regenerate session id
} else {
    $interval = 60 * 30;
    //now check if current time is greater than the last regenerate time
    if (time() - $_SESSION["last_regeneration"] >=$interval){
        regenerate_session_id();  //function to regenerate session id
    }
}
}




//setting the last regeneration is equal to time
//use function instead of rewriting the codes again and again
//when not logged in
function regenerate_session_id(){
    session_regenerate_id(true);
    $_SESSION["last_regeneration"] = time();
}

//when loggin
function regenerate_session_id_loggedin(){
    session_regenerate_id(true);

    $userId = $_SESSION["user_id"];
    $newSessionId = session_create_id();
    $sessionId = $newSessionId . "_" . $userId;
    session_id($sessionId);
    
    $_SESSION["last_regeneration"] = time();
}