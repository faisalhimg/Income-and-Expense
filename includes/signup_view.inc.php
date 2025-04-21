<?php

declare(strict_types=1);

function signup_input (){
    if (isset($_SESSION['signup_data']['firstName'])){
        echo '<div class="form-group">
            <label for="firstName">First Name</label>
            <input 
              type="text" 
              id="firstName" 
              name="firstName" 
              placeholder="John" 
              
              aria-required="true"
              autocomplete="given-name"
              value="'.$_SESSION['signup_data']['firstName'].'"
            >
          </div>';
    } else {
        echo '<div class="form-group">
            <label for="firstName">First Name</label>
            <input 
              type="text" 
              id="firstName" 
              name="firstName" 
              placeholder="John" 
              aria-required="true"
              autocomplete="given-name"
            >
          </div>';       
    }

    if (isset($_SESSION['signup_data']['lastName'])){
        echo ' <div class="form-group">
            <label for="lastName">Last Name</label>
            <input 
              type="text" 
              id="lastName" 
              name="lastName" 
              placeholder="Doe" 
              aria-required="true"
              autocomplete="family-name"
              value="'.$_SESSION['signup_data']['lastName'].'"
            >
          </div>';
    } else {
        echo '<div class="form-group">
            <label for="lastName">Last Name</label>
            <input 
              type="text" 
              id="lastName" 
              name="lastName" 
              placeholder="Doe" 
              aria-required="true"
              autocomplete="family-name"
 
            >
          </div>';
    }

    if (isset($_SESSION['signup_data']['email'])) /*&& isset($_SESSION['errors_signup']['email_used']) && isset($_SESSION["errors_signup"]['invalid_email']))*/{
        echo '<div class="form-group">
            <label for="email">Email Address</label>
            <input 
              type="email" 
              id="email" 
              name="email" 
              placeholder="johndoe@example.com" 
              aria-required="true"
              autocomplete="email"
              value="'.$_SESSION['signup_data']['email'].'"
            >
          </div>';
    } else {
        echo '<div class="form-group">
            <label for="email">Email Address</label>
            <input 
              type="email" 
              id="email" 
              name="email" 
              placeholder="johndoe@example.com" 
              aria-required="true"
              autocomplete="email"
              
            >
          </div>';       
    }
    if (isset($_SESSION['signup_data']['username']) /*&& isset($_SESSION['errors_signup']['username_taken'])*/){
        echo '<div class="form-group">
            <label for="username">User Name</label>
            <input 
              type="text" 
              id="userName" 
              name="username" 
              placeholder="johndoe" 
              aria-required="true"
              autocomplete="username"
              value="'.$_SESSION['signup_data']['username'].'"
            >
          </div>';
    } else {
        echo '<div class="form-group">
            <label for="username">User Name</label>
            <input 
              type="text" 
              id="userName" 
              name="username" 
              placeholder="johndoe" 
              aria-required="true"
              autocomplete="family-name"
              
            >
          </div>';       
    }
    echo '<div class="form-group">
            <label for="password">Password</label>
            <input 
              type="password" 
              id="password" 
              name="password" 
              placeholder="Create a password" 
              aria-required="true"
              autocomplete="new-password"
              minlength="8"
              
            >';
}


function check_signup_error(){
    if(isset($_SESSION['errors_signup'])){
        $errors = $_SESSION['errors_signup'];

        echo '<br>';

        foreach ($errors as $error){
            echo '<p class="form-error" style="color: red;">'. $error .'</p>';
        }

        unset($_SESSION['errors_signup']);
    } else if (isset($_GET['signup']) && $_GET['signup'] ==="success" ){
        echo '<br>';
        echo '<p class="form-success"> Signup Success! </p>';
    }
}