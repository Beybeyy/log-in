<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

// Database connection
$conn = new mysqli("127.0.0.1", "root", "", "ls", 3307);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Check if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim($_POST['email']));

    // 1️⃣ Check if email exists
    $stmt = $conn->prepare("SELECT email FROM login WHERE LOWER(email)=? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $_SESSION['error'] = "We cannot find your email";
        header("Location: forgot_password.php");
        exit();
    }

    // 2️⃣ Generate token
    $token = bin2hex(random_bytes(32));
    $expires = date("Y-m-d H:i:s", strtotime("+1 hour"));

    // 3️⃣ Insert token into password_resets
    $stmt = $conn->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $token, $expires);
    $stmt->execute();

    if ($stmt->affected_rows === 0) {
        $_SESSION['error'] = "Failed to create reset token. Try again.";
        header("Location: forgot_password.php");
        exit();
    }

    // 4️⃣ Create reset link
    $link = "http://localhost/log-in/LISproject/public/reset_password.php?token=$token";

    // 5️⃣ Send email
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "u2460942@gmail.com";  // your Gmail
        $mail->Password = "gulishcnywfcdptg";    // 16-char app password
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;

        $mail->setFrom("u2460942@gmail.com", "LIS System");
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = "Reset Your Password";
        $mail->Body = "
            <p>Hello,</p>
            <p>Click the link below to reset your password. This link will expire in 1 hour.</p>
            <p><a href='$link'>$link</a></p>
            <p>If you did not request this, ignore this email.</p>
        ";

        $mail->send();

        $_SESSION['success'] = "Reset link sent to your email";
        header("Location: forgot_password.php");
        exit();

    } catch (Exception $e) {
        $_SESSION['error'] = "Failed to send email. Please try again later.";
        header("Location: forgot_password.php");
        exit();
    }
}
?>
