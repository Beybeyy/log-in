<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Learner Information System</title>

    <style>
        body {
            margin: 0;
            font-family: "Times New Roman", serif;
            background-color: #ffffff;
        }

        /* NAVBAR */
        .top-nav {
            background-color: #0b3c78;
            padding: 18px 0;
            text-align: center;
        }

        .top-nav a {
            color: #fff;
            text-decoration: none;
            margin: 0 20px;
            font-size: 16px;
        }

        /* MAIN */
        .main-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 80px 100px;
        }

        /*.left-content {
            max-width: 60%;
        }*/

        .welcome-wrapper {
            display: flex;
            align-items: center;
            gap: 140px;
        }

        .welcome-image {
            width: 260px;
            height: auto;
        }

        .welcome-title {
            color: #0b3c78;
            font-size: 52px;
            font-weight:bold;
            line-height: 1.3;
        }

        .description {
            margin-top: 10px;
            margin-left: 295px;
            font-size: 20px;
            max-width: 700px;
            line-height: 1.6;
        }

        /* LOGIN BUTTON */
        .login-btn {
            margin-top: 25px;
            display: inline-block;
            padding: 8px 40px;
            font-size: 14px;
            color: #fff;
            background: linear-gradient(to right, #0b3c78, #7a102a);
            border-radius: 20px;
            text-decoration: none;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .login-btn:hover {
            opacity: 0.9;
        }

        /* RESPONSIVE */
        @media (max-width: 900px) {
            .main-container {
                flex-direction: column;
                padding: 40px 20px;
            }

            .left-content {
                max-width: 100%;
            }

            .welcome-wrapper {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <div class="top-nav">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('about') }}">About</a>
        <a href="#">Contact</a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-container">
        <div class="left-content">

            <div class="welcome-wrapper">
            <img src= "images/deped_matatag_logo.png" 
            alt="DepEd Matatag Logo" 
            class="welcome-logo">

                <h1 class="welcome-title">
                    WELCOME TO <br>
                    LEARNERS INFORMATION SYSTEM <br>
                    
                </h1>
            </div>

            <p class="description">
                A digital platform used by schools to organize, track, and manage
                student-related data in one place. It helps make school operations
                smoother and reduces manual work.
            </p>

            <!-- CONNECTS TO LOGIN PAGE -->
            <a href="../public/login.blade.php" class="login-btn">
                Login
            </a>

        </div>
    </div>

</body>

</html>