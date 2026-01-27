<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Learner Information System</title>
    
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

        /* MAIN LAYOUT */
        .main-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 70px 100px;
        }

        .left-content {
            max-width: 60%;
        }

        .welcome-wrapper {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .welcome-logo{
            width: 290px;
            margin: 0 auto 20px;
        }

        .welcome-title {
            font-size: 52px;
            line-height: 1.3;
            color: #0b3c78;
        }

        .description {
            margin-top: 20px;
            font-size: 20px;
            max-width: 650px;
            line-height: 1.6;
        }

        /* LOGIN CARD */
        .login-card {
            width: 350px;
            padding: 30px;
            border-radius: 15px;
            background: linear-gradient(to bottom, #0b3c78, #7a102a);
            color: white;
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        }

        .login-card h2 {
            margin-bottom: 20px;
            text-align: center;
            font-weight: normal;
        }

        .login-card input,
        .login-card select {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: none;
            margin-bottom: 15px;
            font-size: 14px;
            box-sizing: border-box; /* IMPORTANT */
}

       .remember {
                display: flex;             
                align-items: center;       
                gap: 6px;                 
                font-size: 13px;
                margin-bottom: 15px;
        }

        .remember input[type="checkbox"] {
            width: 16px;               
            height: 16px;
            margin: 0;                 
            vertical-align: middle;    
        }

      .remember label {
        margin: 0;                
        line-height: 1.2;         
    }


        .login-btn {
            width: 100%;
            padding: 10px;
            border-radius: 10px;
            border: none;
            background-color: #0a6ddf;
            color: white;
            font-size: 15px;
            cursor: pointer;
        }

        .login-btn:hover {
            opacity: 0.9;
        }
        
        /*.register-btn {
            display: block;          
            width: 95%;             
            padding: 10px;           
            border-radius: 10px;     
            border: none;
            background-color: #0a6ddf; 
            color: white;
            font-size: 15px;         
            text-align: center;      
            text-decoration: none;   
            margin-top: 10px;        
            cursor: pointer;    
        }

        .register-btn:hover {
                opacity: 0.9;
            } */

        .forgot {
            display: center;
            align-items:center;
            margin-top: 30px;
            font-size: 13px;
            color: #fff;
            text-decoration: underline;
        }

        @media (max-width: 900px) {
            .main-container {
                flex-direction: column;
                gap: 40px;
                padding: 40px 20px;
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
        <a href="/log-in/LISproject/resources/views/pages/home.blade.php">Home</a>
        <a href="#">About</a>
        <a href="#">Contact</a> 
    </div>

    <!-- MAIN -->
    <div class="main-container">

        <!-- LEFT SIDE -->
        <div class="left-content">
            <div class="welcome-wrapper">
            <img src= "images/deped_matatag_logo.png" 
                alt="DepEd Matatag Logo" 
                class="welcome-logo">


                <h1 class="welcome-title">
                    WELCOME TO<br>
                    LEARNER INFORMATION SYSTEM<br>
                    
                </h1>
            </div>

            <p class="description">
                A digital platform used by schools to organize, track, and manage
                student-related data in one place. It helps make school operations
                smoother and reduces manual work.
            </p>
        </div>

        <!-- LOGIN FORM -->
        <div class="login-card">
            <h2>Login</h2>

            <form method="POST" action="login_process.php">

                <input
                    type="email"
                    name="email"
                    placeholder="Email address"
                    required
                >

                <input
                    type="password"
                    name="password"
                    placeholder="Password"
                    required
                >

                <!-- <select name="user_type">
                    <option value="">User Type</option>
                    <option value="Teacher">Teacher</option>
                    <option value="Principal">Principal</option>
                    <option value="SDO/EPS">SDO/EPS</option>
                </select> -->

                <div class="remember">
                    <input type="checkbox" name="remember">
                    <label>Remember me</label>
                </div>

                <button type="submit" class="login-btn">Login</button>

            </form>
               <!-- <a href="register.blade.php" class="register-btn">Register</a> -->
               <a href="{{ route('password.request') }}" class="forgot">
                        Forgot Password ?
                    </a>
        </div>

    </div>

</body>
</html>
