<?php

declare(strict_types = 1);

function output_username(){
    if (isset($_SESSION["user_id"])){
        echo $_SESSION["user_username"];
    } else {
        echo "You are not signed in";
    }
}


function check_signin_error(){
    if (isset($_SESSION['errors_login'])) {
        $errors = $_SESSION['errors_login'];

        echo "<br>";

        foreach ($errors as $error) {
            echo '<p class="form-errors" style="color:red;">'.$error. '</p>';
        }

        unset($_SESSION['errors_login']);
    }
    else if (isset($_GET['login']) && $_GET['login'] === "success"){
        echo '<p class="form-success" style="color:green;">Login successful!</p>';
    }
}