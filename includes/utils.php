<?php
// General utility functions

/**
 * Safely get a value from $_GET, $_POST or other arrays
 * 
 * @param array $array Source array
 * @param string $key Key to get
 * @param mixed $default Default value if key doesn't exist
 * @return mixed Value from array or default
 */
function getValue($array, $key, $default = null) {
    return isset($array[$key]) ? $array[$key] : $default;
}

/**
 * Redirect to a URL
 * 
 * @param string $url URL to redirect to
 */
function redirect($url) {
    header("Location: $url");
    exit;
}

/**
 * Get relative path for navigation
 * 
 * @param string $dir Directory parameter
 * @return string URL encoded directory parameter
 */
function getRelativePath($dir = '') {
    return urlencode($dir);
}

/**
 * Get clean base filename from path
 * 
 * @param string $path File path
 * @return string Clean filename
 */
function getCleanFilename($path) {
    return basename($path);
}

/**
 * Generate URL with parameters
 * 
 * @param array $params URL parameters to include
 * @param array $removeParams Parameters to remove
 * @return string Generated URL
 */
function generateUrl($params = [], $removeParams = []) {
    $currentParams = $_GET;
    
    // Remove any parameters as requested
    foreach ($removeParams as $param) {
        if (isset($currentParams[$param])) {
            unset($currentParams[$param]);
        }
    }
    
    // Add or update parameters
    foreach ($params as $key => $value) {
        $currentParams[$key] = $value;
    }
    
    // Build query string
    $queryString = http_build_query($currentParams);
    
    return '?' . $queryString;
}

/**
 * Get current URL path with directory parameter
 * 
 * @param string|null $dir Directory parameter override
 * @return string URL with dir parameter
 */
function getCurrentUrlWithDir($dir = null, $removeParams = []) {
    $dirParam = $dir !== null ? $dir : ($_GET['dir'] ?? '');
    return generateUrl(['dir' => $dirParam], $removeParams);
}

/**
 * Redirect to URL
 * 
 * @param string $url URL to redirect to
 * @return never
 */
function redirectTo($url) {
    header("Location: $url");
    exit;
}

/**
 * Get the base URL for assets
 * 
 * @return string Base URL for assets
 */
function getBaseUrl() {
    // Get the current script path
    echo $currentPath = $_SERVER['SCRIPT_NAME'];
    // Get directory part of the path
    $dirPath = dirname($currentPath);
    // If we're at web root, return empty, otherwise return path with trailing slash
    return ($dirPath == '/') ? '/' : $dirPath . '/';
}

/**
 * Get CSS class for file type based on extension
 * 
 * @param string $filename File name
 * @return string CSS class for file type
 */
function getFileTypeClass($filename) {
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    
    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'];
    $codeExtensions = ['php', 'html', 'css', 'js', 'ts', 'jsx', 'tsx', 'py', 'java', 'c', 'cpp', 'json', 'xml'];
    $docExtensions = ['doc', 'docx', 'pdf', 'txt', 'md', 'rtf', 'odt', 'xls', 'xlsx', 'ppt', 'pptx'];
    $zipExtensions = ['zip', 'rar', 'tar', 'gz', '7z'];
    
    if (in_array($extension, $imageExtensions)) {
        return 'image';
    } elseif (in_array($extension, $codeExtensions)) {
        return 'code';
    } elseif (in_array($extension, $docExtensions)) {
        return 'doc';
    } elseif (in_array($extension, $zipExtensions)) {
        return 'zip';
    } else {
        return 'default';
    }
}
?>