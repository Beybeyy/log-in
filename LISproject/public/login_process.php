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
    $email_input = $_POST['email'];
    $password_input = $_POST['password'];

    // Check user
    $sql = "SELECT * FROM login WHERE email=? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email_input);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if ($password_input === $user['password']) {
            // Login successful
            $_SESSION['email'] = $user['email'];
            $_SESSION['user_id'] = $user['id'];       // optional: track user
            $_SESSION['LAST_ACTIVITY'] = time();     // track activity for inactivity logout

            // Show alert and redirect
            echo "<script>
                alert('Login successful! Welcome, " . $user['email'] . "');
                window.location.href = 'teacher.interface.php';
            </script>";
            exit(); // stop further execution

        } else {
            // Invalid password
            echo "<script>
                alert('Invalid password!');
                window.history.back();
            </script>";
            exit();
        }
    } else {
        // Invalid email
        echo "<script>
            alert('Invalid email address!');
            window.history.back();
        </script>";
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
