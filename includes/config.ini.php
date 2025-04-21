<?php

ini_set('session.use_only_cookies', 1); //1 means true 0 means false
ini_set('session.strict_mode', 1);

session_set_cookie_params([
    'lifetime' => 1800 ,//set life time
    'domain' => 'localhost',// your website goes here
    'path' => '/', //all pages in the domain
    'secure' => true,//only work in https
    'httponly' => true //restrict script from clients
]);

session_start();

//check if session is created and if not created create one
if(!isset($_SESSION['last_regeneration'])){
    session_regenerate_id(true); // to regenerate session id
    $_SESSION['last_regeneration'] = time();
} else {
    $interval = 60 * 30; //30 min interval to regenerate new id

    //
    if (time() - $_SESSION['last_regeneration'] >=$interval){
        session_regenerate_id(true);
        $_SESSION['last_regeneratiion'] = time();
    }
}





