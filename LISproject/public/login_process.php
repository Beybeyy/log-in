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

// Only process if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email_input = trim($_POST['email']);
    $password_input = trim($_POST['password']);

    // Check user
    $sql = "SELECT * FROM login WHERE email=? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email_input);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Check password (plain text for now; you can hash later)
        if ($password_input === $user['password']) {
            // Login successful
            $_SESSION['email'] = $user['email'];
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['LAST_ACTIVITY'] = time(); // track last activity for session timeout

            // Redirect to dashboard
            header("Location: teacher.interface.php");
            exit();

        } else {
            // Invalid password
            header("Location: login.blade.php?message=invalid_password");
            exit();
        }

    } else {
        // Invalid email
        header("Location: login.blade.php?message=invalid_email");
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
