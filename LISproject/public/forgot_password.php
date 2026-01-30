<?php
// forgot_password.php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIS | Forgot Password</title>
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

        /* Container & Card */
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

        .card-body p {
            font-size: 16px;
            color: #333;
            margin-bottom: 25px;
            line-height: 1.5;
        }

        input[type="email"] {
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
            <div class="icon-circle">!</div>
            <h2>Forgot Password</h2>
        </div>

        <div class="card-body">
            <p>Enter your email address and we will send you a link to reset your password.</p>

            <form action="send_reset_email.php" method="POST">

                <input
                    type="email"
                    name="email"
                    placeholder="Enter your email"
                    required
                    autocomplete="off">

                <!-- ERROR MESSAGE BELOW INPUT -->
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="error-text"><?php echo $_SESSION['error']; ?></div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <!-- SUCCESS MESSAGE BELOW INPUT -->
                <?php if (isset($_SESSION['success'])): ?>
                    <div style="color: green; margin-bottom:15px; text-align:left;">
                        <?php echo $_SESSION['success']; ?>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <button type="submit" class="btn-submit">Submit</button>
            </form>

            <a href="http://localhost/log-in/LISproject/public/login.blade.php" class="back-link">
                <span>&#8249;</span> back to login
            </a>
        </div>
    </div>
</div>

</body>
</html>
