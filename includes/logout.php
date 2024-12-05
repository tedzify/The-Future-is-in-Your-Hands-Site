<?php 
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Delete the cookie
setcookie("admin_id", "", time() - 3600, "/");

// Redirect to login page
header("Location: /The-Future-is-in-Your-Hands-Site/public/AdminLogin");
exit();
?>