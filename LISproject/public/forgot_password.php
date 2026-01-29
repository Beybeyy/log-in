<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
</head>
<body>

<h2>Forgot Password</h2>

<p>Enter your email to receive a password reset link.</p>

<form action="send_reset_email.php" method="POST">
    <input type="email" name="email" placeholder="Enter your email" required>
    <button type="submit">Send Reset Link</button>
</form>

</body>
</html>
