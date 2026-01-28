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

        /* Left Brand Side */
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

        /* MAIN */
        .main-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 80px 100px;
            max-width: 1200px;
        }

        /*.left-content {
            max-width: 60%;
        }*/

        .welcome-wrapper {
            display: flex;
            align-items: center;
            gap: 40px;
            
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
            margin-left:340px;
            font-size: 20px;
            max-width: 700px;
            line-height: 1.6;
        }

        /* LOGIN BUTTON */
        .login-btn {
            margin-top: 25px;
            margin-left: 80px;
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
            .welcome-logo{
                width: 300px;
                margin: 0 auto 20px;
            }


    </style>
</head>

<body>

    <!-- NAVBAR -->
    <div class="top-nav">
        <div class="nav-brand">
            Department of Education<br>
            <small>Learning Information System</small>
        </div>
       
        <div class="nav-links">
            <a href="http://localhost/log-in/LISproject/resources/views/pages/home.blade.php">Home</a>
            <a href="http://localhost/log-in/LISproject/resources/views/pages/about.blade.php">About</a>
            <a href="http://localhost/log-in/LISproject/resources/views/pages/contact.blade.php">Contact</a>
            </div>    
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-container">
        <div class="left-content">

            <div class="welcome-wrapper">
            <img src="http://localhost/log-in/LISproject/public/images/deped_matatag_logo.png" 
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
            <a href="http://localhost/log-in/LISproject/public/login.blade.php"  class="login-btn" id="loginBtn">
                Login
            </a>

        </div>
    </div>
        <script>
    document.getElementById('loginBtn').addEventListener('click', function(e) {
        e.preventDefault(); // Stop immediate navigation
        
        const button = this;
        const originalText = button.innerHTML;
        const href = button.getAttribute('href');
        
        // 1. Add click animation class
        button.classList.add('clicked');
        
        // 2. Change to loading text with dots animation
        button.innerHTML = 'Loading';
        
        let dots = 0;
        const loadingInterval = setInterval(() => {
            dots = (dots + 1) % 4;
            button.innerHTML = 'Loading' + '.'.repeat(dots);
        }, 300);
        
        // 3. Wait 800ms (0.8 seconds) for loading animation
        setTimeout(() => {
            // Clear the loading dots animation
            clearInterval(loadingInterval);
            
            // 4. Show "Redirecting..." text
            button.innerHTML = '✓ Redirecting...';
            button.style.background = 'linear-gradient(to right, #2ecc71, #27ae60)';
            
            // 5. Optional: Fade out the whole page
            document.body.style.opacity = '0.8';
            document.body.style.transition = 'opacity 0.3s ease';
            
            // 6. Wait 400ms more then redirect
            setTimeout(() => {
                window.location.href = href;
            }, 400);
            
        }, 800); // Loading animation duration
    });
</script>
</body>

</html>