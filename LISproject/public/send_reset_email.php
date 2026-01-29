<?php
use PHPMailer\PHPMailer\PHPMailer;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

// Database connection
$conn = new mysqli("localhost", "root", "", "ls");

// Get the email from the form
$email = $_POST['email'];

// 1️⃣ Check if the email exists in your login table
$stmt = $conn->prepare("SELECT email FROM login WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Email not found in database");
}

// 2️⃣ Generate a secure token
$token = bin2hex(random_bytes(32));
$expires = date("Y-m-d H:i:s", strtotime("+1 hour"));

// 3️⃣ Save the token in the password_resets table
$stmt = $conn->prepare(
    "INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)"
);
$stmt->bind_param("sss", $email, $token, $expires);
$stmt->execute();

// 4️⃣ Create the password reset link
$link = "http://localhost/LISproject/public/reset_password.php?token=$token";


// 5️⃣ Send email using PHPMailer
$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->Host = "smtp.gmail.com";
$mail->SMTPAuth = true;
$mail->Username = "u2460942@gmail.com";       // Replace with your Gmail
$mail->Password = "gulishcnywfcdptg";         // Replace with your 16-char App Password
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

echo "Reset email sent! Check your inbox.";
