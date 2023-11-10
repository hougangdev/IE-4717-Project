<?php
session_start(); // Start the session.

// If there's a user logged in, then we can log them out.
if (isset($_SESSION['user_id']) || isset($_COOKIE['login_status'])) {
    // Unset all of the session variables.
    $_SESSION = array();
    
    // If it's desired to kill the session, also delete the session cookie.
    // Note: This will destroy the session, and not just the session data!
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Destroy the session.
    session_destroy();

    // Delete the 'login_status' cookie by setting its expiration to an hour ago.
    setcookie("login_status", "", time() - 3600, "/");

    // Use JavaScript for client-side redirection with an alert.
    echo '<script>';
    echo 'alert("Logout successfully!");';
    echo 'window.location.href = "home.php";';
    echo '</script>';
    exit();

}

// If not logged in, redirect to the login page
else {
    header("Location: login.php");
    exit();
}
?>
