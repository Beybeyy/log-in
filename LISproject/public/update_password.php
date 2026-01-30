<?php
session_start();

// Connect to database
$conn = new mysqli("127.0.0.1", "root", "", "ls", 3306);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Check POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = isset($_POST['token']) ? $_POST['token'] : '';
    $new_password = isset($_POST['password']) ? $_POST['password'] : '';

    if (!$token || !$new_password) {
        $_SESSION['error'] = "Missing data. Try again.";
        header("Location: reset_password.php?token=" . urlencode($token));
        exit();
    }

    // Verify token
    $stmt = $conn->prepare("SELECT email, expires_at FROM password_resets WHERE token=? LIMIT 1");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $_SESSION['error'] = "Invalid or expired link";
        header("Location: forgot_password.php");
        exit();
    }

    $token_data = $result->fetch_assoc();
    if (strtotime($token_data['expires_at']) < time()) {
        $_SESSION['error'] = "This reset link has expired";
        header("Location: forgot_password.php");
        exit();
    }

    $email = $token_data['email'];

    // Hash the password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update password
    $stmt = $conn->prepare("UPDATE login SET password=? WHERE email=?");
    $stmt->bind_param("ss", $hashed_password, $email);
    $stmt->execute();

    if ($stmt->affected_rows === 0) {
        $_SESSION['error'] = "Failed to update password. Try again.";
        header("Location: reset_password.php?token=" . urlencode($token));
        exit();
    }

    // Delete token
    $stmt = $conn->prepare("DELETE FROM password_resets WHERE token=?");
    $stmt->bind_param("s", $token);
    $stmt->execute();

    $_SESSION['success'] = "✅ Password updated successfully! You can now login with your new password.";
    header("Location: login.blade.php");
    exit();
}
?>
