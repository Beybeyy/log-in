<?php
session_start();

// Get token from URL
$token = isset($_GET['token']) ? $_GET['token'] : '';

if (!$token) {
    $_SESSION['error'] = "Invalid or expired link";
    header("Location: forgot_password.php");
    exit();
}

// ✅ Database connection (no external file needed)
$conn = new mysqli("127.0.0.1", "root", "", "ls", 3306);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Check if token exists and not expired
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

// Check if token has expired
if (strtotime($token_data['expires_at']) < time()) {
    $_SESSION['error'] = "This reset link has expired";
    header("Location: forgot_password.php");
    exit();
}

$email = $token_data['email'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIS | Reset Password</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <style>
        body {
            margin: 0;
            font-family: "Times New Roman", serif;
            background-color: #ffffff;
            overflow-x: hidden;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80vh;
            padding: 20px;
        }
        .card {
            width: 100%;
            max-width: 450px;
            background-color: #083e77;
            border: 10px solid #083e77;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .card-header {
            padding: 40px 20px 20px;
            text-align: center;
            color: white;
        }
        .icon-circle {
            width: 50px;
            height: 50px;
            border: 3px solid white;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            font-weight: bold;
        }
        .card-body {
            background-color: #dcdcdc;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 10px;
            font-size: 14px;
        }
        .error-text {
            color: #d93025;
            font-size: 14px;
            margin-bottom: 15px;
            text-align: left;
        }
        .btn-submit {
            width: 100%;
            background-color: #1a73e8;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-bottom: 20px;
            transition: background 0.3s;
        }
        .btn-submit:hover {
            background-color: #155cb0;
        }
        .back-link {
            display: block;
            color: #333;
            text-decoration: none;
            font-size: 16px;
            margin-top: 10px;
        }
        .back-link span {
            font-size: 18px;
            vertical-align: middle;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="icon-circle">🔒</div>
            <h2>Reset Password</h2>
        </div>
        <div class="card-body">
            <form action="update_password.php" method="POST">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

                <input type="password" name="password" placeholder="Enter new password" required autocomplete="off">

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="error-text"><?php echo $_SESSION['error']; ?></div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['success'])): ?>
                    <div style="color: green; margin-bottom:15px; text-align:left;">
                        <?php echo $_SESSION['success']; ?>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <button type="submit" class="btn-submit">Update Password</button>
            </form>

            <a href="login.blade.php" class="back-link">
                <span>&#8249;</span> back to login
            </a>
        </div>
    </div>
</div>

</body>
</html>
