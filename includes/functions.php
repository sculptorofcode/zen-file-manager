<?php
// Main functions file that includes all other function files

// Include configuration
require_once __DIR__ . '/config.php';

// Include session management functions
require_once __DIR__ . '/session_manager.php';

// Include file operations
require_once __DIR__ . '/file_operations.php';

// Include directory operations
require_once __DIR__ . '/dir_operations.php';

// Include file utilities
require_once __DIR__ . '/file_utils.php';

// Include template functions
require_once __DIR__ . '/template_functions.php';
?>