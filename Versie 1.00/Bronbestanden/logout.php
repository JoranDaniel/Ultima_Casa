<?php
session_start();

if (isset($_POST['logout']) && $_POST['logout'] == 1) {
    // Perform any additional cleanup tasks if needed

    // Destroy the session
    session_unset();
    session_destroy();

    // Redirect to the login page or any other appropriate page after logout
    header("Location: login.php"); // Change "login.php" to the actual login page
    exit();
}
?>
