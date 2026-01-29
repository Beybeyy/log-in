<?php
$conn = new mysqli("localhost", "root", "", "ls");

// Get the token from the URL
$token = $_GET['token'];

// Check if token exists and is not expired
$stmt = $conn->prepare(
    "SELECT email FROM password_resets WHERE token=? AND expires_at > NOW()"
);
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Invalid or expired link");
}

// Get the email associated with the token
$row = $result->fetch_assoc();
$email = $row['email'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>

<h2>Reset Your Password</h2>

<form action="update_password.php" method="POST">
    <input type="hidden" name="email" value="<?= $email ?>">
    <input type="password" name="password" placeholder="New password" required>
    <button type="submit">Update Password</button>
</form>

</body>
</html>
