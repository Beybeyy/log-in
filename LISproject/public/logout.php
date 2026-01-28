
<?php
session_start();
session_unset();
session_destroy();

// Redirect to login page with session expired message
header("Location: login.blade.php?message=session_expired");
exit();
?>