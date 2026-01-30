<?php
session_start();

// Database connection
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "ls";
$port = 3306;

$conn = new mysqli($servername, $db_username, $db_password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 🔒 Normalize inputs
    $email_input = strtolower(trim($_POST['email']));
    $password_input = trim($_POST['password']);

    // 🔍 Check user by email
    $sql = "SELECT id, email, password FROM login WHERE LOWER(email) = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email_input);
    $stmt->execute();
    $result = $stmt->get_result();

    // ❌ Email not found
    if ($result->num_rows !== 1) {
        header("Location: login.blade.php?message=login_failed");
        exit();
    }

    $user = $result->fetch_assoc();

    // ❌ Password incorrect (plain text version)
    if ($password_input !== $user['password']) {
        header("Location: login.blade.php?message=login_failed");
        exit();
    }

    // ✅ LOGIN SUCCESS
    $_SESSION['email'] = $user['email'];
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['LAST_ACTIVITY'] = time();

    $_SESSION['message'] = '🎉 You are logged in successfully!';
    $_SESSION['messageType'] = 'success';

    header("Location: teacher.interface.php");
    exit();
}

$conn->close();
?>
