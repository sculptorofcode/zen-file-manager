<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
/**
 * Simple authentication system
 */

// Define the single user's credentials
// Username: NovaRidge_2749
// Password: vP!7rLz#9mXqT@2f
$AUTH_USERNAME = '$2y$10$nmK8spkb32rLA2dWD79ufOr/tp8tIweuLmzSLB/kdbEbpjyDmk3lu';
$AUTH_PASSWORD = '$2y$10$Uozs6VHOvkRSHmjqZWhq2OAuBCZq77aZ9lnsg.O4Lso05HJaIZaoC';

/**
 * Verify if the provided credentials are valid
 * 
 * @param string $username The username to verify
 * @param string $password The password to verify
 * @return bool True if credentials are valid, false otherwise
 */
function verify_credentials($username, $password)
{
    global $AUTH_USERNAME, $AUTH_PASSWORD;
    return password_verify($username, $AUTH_USERNAME) && password_verify($password, $AUTH_PASSWORD);
}

/**
 * Check if the user is logged in
 * 
 * @return bool True if the user is logged in, false otherwise
 */
function is_authenticated()
{
    return isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true;
}

/**
 * Log the user in
 * 
 * @param string $username The username
 * @param string $password The password
 * @return bool True if login was successful, false otherwise
 */
function login($username, $password)
{
    if (verify_credentials($username, $password)) {
        $_SESSION['authenticated'] = true;
        $_SESSION['username'] = $username;
        return true;
    }
    return false;
}

/**
 * Log the user out
 */
function logout()
{
    unset($_SESSION['authenticated']);
    unset($_SESSION['username']);
    session_destroy();
}
