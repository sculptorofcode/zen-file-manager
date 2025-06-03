<?php
// Configuration settings for the file manager

// Set the base directory to htdocs (or change it to any desired root directory)
if(!defined('BASE_DIR')) {
    define('BASE_DIR', realpath(__DIR__ . '/..')); // Adjust as needed
}

// Define the base URL for web access
if(!defined('BASE_URL')) {
    // Auto-detect the base URL based on server variables
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'];
    
    // Calculate the relative path from document root to BASE_DIR
    $documentRoot = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
    $baseDir = str_replace('\\', '/', BASE_DIR);
    
    // Extract the path difference to create the URL path
    if (strpos($baseDir, $documentRoot) === 0) {
        $urlPath = substr($baseDir, strlen($documentRoot));
    } else {
        // Fallback if BASE_DIR is not under document root
        $script_name = dirname($_SERVER['SCRIPT_NAME']);
        $urlPath = rtrim(str_replace('\\', '/', $script_name), '/');
    }
    
    // Define constant - ensure path starts with a slash
    $urlPath = '/' . ltrim($urlPath, '/');
    define('BASE_URL', $protocol . $host . $urlPath);
}

const VERSION = '1.0.0'; // Version of the file manager
const RELEASE = 'June 2025';

// Other global configuration options can be added here
?>