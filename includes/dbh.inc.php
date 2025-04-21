<?php

$host = "localhost"; 
$dbname = "gigdatabase";
$dbusername = "root";
$dbpassword = "";

try {
    $pdo= new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);//Connecting to gigdatabase...
    // check for errors if connection fails...
    $pdo-> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    //echo "Connection Successfully!";
} catch (PDOException $e) { //e is the placeholder for variable
    
    die("Connection failed:". $e->getMessage());
}