<?php
session_start();
session_unset();
session_destroy();
header("Location: http://localhost/log-in/LISproject/resources/views/pages/home.blade.php"); // redirect to login page
exit();
