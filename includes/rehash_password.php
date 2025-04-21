<?php
require_once 'dbh.inc.php';

$username = 'johndoe'; // or use userID
$password = '12345678';

// Hash the new password
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// Update it in the database
$sql = "UPDATE users SET password = :hashedPassword WHERE username = :username";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':hashedPassword' => $hashedPassword,
    ':username' => $username
]);

echo "Password rehashed and updated successfully.";
?>
