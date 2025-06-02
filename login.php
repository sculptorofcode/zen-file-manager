<?php
/**
 * Login page for the file manager
 */
require_once 'includes/session_manager.php';
require_once 'includes/auth.php';

$error = '';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    
    if (login($username, $password)) {
        // Redirect to index.php after successful login
        header('Location: index.php');
        exit;
    } else {
        $error = 'Invalid username or password';
    }
}

// If user is already logged in, redirect to index.php
if (is_authenticated()) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - File Manager</title>
    <link rel="stylesheet" href="assets/css/improved-styles.css">
    <link rel="stylesheet" href="assets/libs/font-awesome/css/all.min.css">
</head>
<body class="login-page">
    <div class="login-container">
        <h1>File Manager</h1>
        <form method="post" action="login.php" class="login-form">
            <?php if (!empty($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <div class="form-group">
                <label for="username"><i class="fas fa-user"></i> Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password"><i class="fas fa-lock"></i> Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="login-btn">Login</button>
        </form>
    </div>
    
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
