<?php

declare(strict_types = 1);

//NO8 check for empty form error next step is singin inc
function is_input_empty(string $username, string $password){
    if(empty($username) || empty($password)){
        return true;
    } else {
        return false;
    }
}


//NO6
function is_username_wrong(bool|array $result){
    if (!$result){
        return true;
    } else {
        return false;
    }
}
//NO7
function is_password_wrong(string $password, string $hashedPwd){
    if (!password_verify($password, $hashedPwd)){
        return true;
    } else {
        return false;
    }
}