<?php
$conn = new mysqli("localhost", "root", "", "ls");

if ($conn->connect_error) {
    die("Connection failed");
}

$email = $_POST['email'];

// Check if email exists
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: forgot_password.php?message=email_not_found");
    exit();
}

// TEMPORARY PASSWORD (for demo)
$newPassword = "123456";
$hashed = password_hash($newPassword, PASSWORD_DEFAULT);

// Update password
$update = "UPDATE users SET password = ? WHERE email = ?";
$stmt = $conn->prepare($update);
$stmt->bind_param("ss", $hashed, $email);
$stmt->execute();

header("Location: login.blade.php?message=logged_out");
exit();
