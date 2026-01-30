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
$conn = new mysqli("127.0.0.1", "root", "", "ls", 3307);
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
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&family=Roboto&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: "Times New Roman", serif;
            background-color: #ffffff;
            overflow-x: hidden;
        }

        /* NAVBAR */
        .top-nav {
            background-color: #0b3c78;
            padding: 18px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: white;
        }

        .nav-brand {
            text-align: left;
            line-height: 1.2;
            margin-left: 20px;
            font-weight: bold;
            font-size: 18px;
        }

        .nav-brand small {
            font-weight: normal;
            font-size: 14px;
            opacity: 0.9;
        }

        .nav-links {
            display: flex;
            align-items: center;
        }

        .top-nav a {
            color: #fff;
            text-decoration: none;
            margin: 0 20px;
            font-size: 16px;
        }

        .top-nav a:hover {
            text-decoration: underline;
        }


        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80vh;
            padding: 20px;
        }

        /* Reset Card */
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
            padding: 30px 20px;
            text-align: center;
            color: white;
        }
        .icon-circle {
            width: 60px;
            height: 60px;
            border: 3px solid white;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            margin-bottom: 15px;
        }
        .card-body {
            background-color: #d3d3d3; /* Light grey from image */
            padding: 20px 25px;
            border-radius: 5px;
            text-align: center;
        }

        .instruction-text {
            font-size: 14px;
            color: #333;
            margin-bottom: 20px;
            line-height: 1.4;
        }

        /* Input Fields */
        .input-group {
            text-align: left;
            margin-bottom: 15px;
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
        /* Feedback Messages */
        .error-text { 
            color: #d93025; 
            font-size: 13px; 
            margin-top: 5px; 
            display: none; 
        }

        .success-text { 
            color: #2e7d32; 
            font-size: 14px; 
            margin-bottom: 15px; 
        
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

    <!-- NAVBAR -->
    <nav class="top-nav">
        <div class="nav-brand">
            Department of Education<br>
            <small>Learning Information System</small>
        </div>
        <div class="nav-links">
            <a href="http://localhost/log-in/LISproject/resources/views/pages/home.blade.php">Home</a>
            <a href="http://localhost/log-in/LISproject/resources/views/pages/about.blade.php">About</a>
            <a href="http://localhost/log-in/LISproject/resources/views/pages/contact.blade.php">Contact</a>
        </div>
    </nav>

<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="icon-circle">🔒︎</div>
            <h2>Reset Password</h2>
        </div>
        <div class="card-body">
        <p class="instruction-text">Please enter your new password below and confirm it to update your account.</p>
            
        <form id="resetForm" action="update_password.php" method="POST">
                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token'] ?? ''); ?>">

                    <div class="input-group">
                        <input type="password" id="password" name="password" placeholder="Enter new password" required>
                    </div>

                    <div class="input-group">
                        <input type="password" id="confirm_password" placeholder="Confirm new password" required>
                        <div id="match-error" class="error-text">password not matched !</div>
                    </div>


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

<script>
        const form = document.getElementById('resetForm');
        const pass = document.getElementById('password');
        const confirmPass = document.getElementById('confirm_password');
        const errorMsg = document.getElementById('match-error');

        form.onsubmit = function(e) {
            if (pass.value !== confirmPass.value) {
                e.preventDefault(); // Stop form from sending
                errorMsg.style.display = 'block';
                confirmPass.style.borderColor = '#d93025';
                return false;
            }
        };

        // Hide error when user starts typing again
        confirmPass.oninput = function() {
            errorMsg.style.display = 'none';
            confirmPass.style.borderColor = '#ccc';
        };
    </script>
</body>
</html>
