<?php
session_start();

// Database connection
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "ls";
$port = 3307;

$conn = new mysqli($servername, $db_username, $db_password, $dbname, $port);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email_input = strtolower(trim($_POST['email']));
    $password_input = trim($_POST['password']);

    $sql = "SELECT id, email, password FROM login WHERE LOWER(email) = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email_input);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows !== 1) {
        $_SESSION['error'] = '❌ Invalid email or password';
        header("Location: login.blade.php");
        exit();
    }

    $user = $result->fetch_assoc();

    // Check if password is hashed (for old accounts, fallback to plain)
    if (password_get_info($user['password'])['algo'] !== 0) {
        // password is hashed
        if (!password_verify($password_input, $user['password'])) {
            $_SESSION['error'] = '❌ Invalid email or password';
            header("Location: login.blade.php");
            exit();
        }
    } else {
        // password is plain text (old accounts)
        if ($password_input !== $user['password']) {
            $_SESSION['error'] = '❌ Invalid email or password';
            header("Location: login.blade.php");
            exit();
        }
    }

    // Login success
    $_SESSION['email'] = $user['email'];
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['LAST_ACTIVITY'] = time();

    $_SESSION['success'] = '🎉 You are logged in successfully!';
    header("Location: teacher.interface.php");
    exit();
}

$conn->close();
?>
