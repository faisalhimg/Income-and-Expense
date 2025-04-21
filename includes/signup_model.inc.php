<?php
declare(strict_types=1);

function get_username(object $pdo, string $username)
 {
    $query = "SELECT username FROM users WHERE username = :username;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function get_email(object $pdo, string $email)
 {
    $query = "SELECT email FROM users WHERE email = :email;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function set_user(
    object $pdo, 
    string $firstName, 
    string $lastName, 
    string $username, 
    string $email, 
    string $password
){
    $query = "INSERT INTO users 
    (firstName, 
    lastName, 
    username, 
    email, 
    password) 
             VALUES (:firstName, 
              :lastName, 
              :username, 
              :email, 
              :password)";
    
    $stmt = $pdo->prepare($query);
    $hashedPwd = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    
    $stmt->execute([
        ':firstName' => $firstName,
        ':lastName' => $lastName,
        ':username' => $username,
        ':email' => $email,
        ':password' => $hashedPwd
    ]);
}