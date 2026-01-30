<?php
session_start(); // Make sure session is started

$message = '';
$messageType = '';

if (isset($_GET['message'])) {
    switch ($_GET['message']) {

        case 'session_expired':
            $message = '⏰ Session expired. Please log in again.';
            $messageType = 'error';
            break;

        case 'not_logged_in':
            $message = '⚠️ You must log in first.';
            $messageType = 'error';
            break;

        case 'logged_out':
            $message = '✅ You have logged out successfully.';
            $messageType = 'success';
            break;

        case 'logged_in':
            $message = '🎉 You are logged in successfully!';
            $messageType = 'success';
            break;

        // ✅ NEW unified login error
        case 'login_failed':
            $message = '❌ Invalid email or password.';
            $messageType = 'error';
            break;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login | Learner Information System</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<style>
body { margin:0; font-family:"Times New Roman", serif; background:#fff; overflow-x:hidden; }

/* NAVBAR */
.top-nav {
    background-color: #0b3c78;
    padding: 18px 0;
    display:flex;
    align-items:center;
    justify-content:space-between;
    color:white;
}

.nav-brand { text-align:left; line-height:1.2; font-weight:bold; font-size:18px; margin-left:20px; }
.nav-brand small { font-weight:normal; font-size:14px; opacity:0.9; }

.nav-links a { color:white; text-decoration:none; margin:0 20px; font-size:16px; }
.nav-links a:hover { text-decoration:underline; }

/* MAIN LAYOUT */
.main-container { display:flex; justify-content:space-between; align-items:center; padding:70px 100px; }
.left-content { max-width:60%; }
.welcome-wrapper { display:flex; gap:30px; align-items:center; }
.welcome-logo { width:300px; margin:0 auto 20px; }
.welcome-title { font-size:52px; line-height:1.3; color:#0b3c78; }
.description { margin-top:20px; font-size:20px; max-width:650px; line-height:1.6; }

/* LOGIN CARD */
.login-card {
    width:350px;
    padding:30px;
    border-radius:15px;
    background: linear-gradient(to bottom, #1a3c6d, #7a102a);
    color:white;
    box-shadow:0 8px 20px rgba(0,0,0,0.3);
    flex-shrink:0;
}
.login-card h2 { text-align:center; margin-bottom:50px; font-weight:normal; }

/* FORM ELEMENTS */
.form-group { width:100%; margin-bottom:15px; position:relative; }
.login-card input, .login-card select {
    width:100%;
    padding:12px 15px;
    padding-right:45px;
    border-radius:12px;
    border:none;
    font-size:14px;
    box-sizing:border-box;
    background-color:white;
    display:block;
}

/* EYE ICON */
.toggle-password {
    position:absolute;
    right:15px;
    top:50%;
    transform:translateY(-50%);
    color:#666;
    cursor:pointer;
    font-size:18px;
    z-index:10;
}

.login-btn {
    width:100%;
    padding:10px;
    border-radius:10px;
    border:none;
    background-color:#0a6ddf;
    color:white;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}
.login-btn:hover { background-color:#0056b3; }

.forgot { display:block; text-align:center; margin-top:50px; color:#fff; font-size:14px; text-decoration:underline; }

/* TOAST */
#toast {
    position:fixed;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
    background-color:rgba(0,0,0,0.8);
    color:white;
    padding:20px 30px;
    border-radius:10px;
    font-size:16px;
    text-align:center;
    z-index:9999;
    opacity:0;
    animation: fadein 0.5s forwards, fadeout 0.5s 3s forwards;
}
#toast.success { background-color:green; }
#toast.error { background-color:red; }

@keyframes fadein { from { opacity:0; } to { opacity:1; } }
@keyframes fadeout { from { opacity:1; } to { opacity:0; } }

/* Responsive */
@media (max-width:850px) {
    .main-container { flex-direction:column; text-align:center; padding:40px 20px; }
    .welcome-wrapper { flex-direction:column; }
}
</style>
</head>
<body>

<?php if(!empty($message)): ?>
    <div id="toast" class="<?= $messageType ?>"><?= $message ?></div>
    <script>
        // Remove 'message' from URL after showing
        if(window.history.replaceState){
            const url = new URL(window.location);
            url.searchParams.delete('message');
            window.history.replaceState({}, document.title, url);
        }

        // Remove toast after animation
        const toast = document.getElementById('toast');
        setTimeout(() => { if(toast) toast.remove(); }, 3500);
    </script>
<?php endif; ?>

<!-- NAVBAR -->
<nav class="top-nav">
    <div class="nav-brand">
        Department of Education<br>
        <small>Learning Information System</small>
    </div>
    <div class="nav-links">
        <a href="http://localhost/log-in/LISproject/resources/views/pages/home.blade.php">Home</a>
        <a href="http://localhost/log-in/LISproject/resources/views/pages/about.blade.php">About</a>
        <a href="http://localhost/log-in/LISproject/resources/views/pages/.blade.php">Contact</a>
    </div>
</nav>

<!-- MAIN -->
<main class="main-container">
    <div class="left-content">
        <div class="welcome-wrapper">
            <img src="images/deped_matatag_logo.png" alt="Logo" class="welcome-logo">
            <h1 class="welcome-title">WELCOME TO <br> LEARNER INFORMATION SYSTEM</h1>
        </div>
        <p class="description">A digital platform used by schools to organize, track, and manage student-related data in one place.</p>
    </div>

    <div class="login-card">
        <h2>Login</h2>
        <form action="login_process.php" method="POST">
            <div class="form-group">
                <input type="email" name="email" placeholder="Email address" required autocomplete="off">
            </div>

            <div class="form-group">
                <input type="password" name="password" id="password" placeholder="Password" required autocomplete="off">
                <i class="fa-regular fa-eye toggle-password" id="eyeIcon"></i>
            </div>

            <button type="submit" class="login-btn">Login</button>
            <a href="forgot_password.php" class="forgot">Forgot Password?</a>
        </form>
    </div>
</main>
    
<script>
const passwordInput = document.getElementById('password');
const eyeIcon = document.getElementById('eyeIcon');
eyeIcon.addEventListener('click', () => {
    passwordInput.type = (passwordInput.type === 'password') ? 'text' : 'password';
    eyeIcon.classList.toggle('fa-eye');
    eyeIcon.classList.toggle('fa-eye-slash');
});
</script>

</body>
</html>
