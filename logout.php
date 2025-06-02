<?php
/**
 * Logout page for the file manager
 */
require_once 'includes/session_manager.php';
require_once 'includes/auth.php';

// Log the user out
logout();

// Redirect to login page
header('Location: login.php');
exit;
?>
