<?php
$conn = new mysqli("localhost", "root", "", "ls");

// Get form data
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the new password

// Update the password in login table
$stmt = $conn->prepare("UPDATE login SET password=? WHERE email=?");
$stmt->bind_param("ss", $password, $email);
$stmt->execute();

// Delete the token from password_resets table
$stmt = $conn->prepare("DELETE FROM password_resets WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();

echo "✅ Password updated successfully! You can now login with your new password.";
