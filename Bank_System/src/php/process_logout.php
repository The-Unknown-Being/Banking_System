<?php
// Start session
session_start();

// Destroy all session data
session_unset();

// Destroy the session itself
session_destroy();

// Redirect the user to the login page
header("Location: ../../index.html");
exit;
?>
