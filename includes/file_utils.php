<?php
// Utility functions for files

/**
 * Get file size in human readable format
 * 
 * @param int $bytes Size in bytes
 * @return string Formatted size with unit
 */
function humanFilesize($bytes) {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    return round($bytes / (1024 ** $pow), 2) . ' ' . $units[$pow];
}

/**
 * Get appropriate icon for a file based on its extension
 * 
 * @param string $filename Filename
 * @return string CSS class for FontAwesome icon
 */
function getFileIcon($filename) {
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $iconMap = [
        'pdf' => 'file-pdf',
        'doc' => 'file-word',
        'docx' => 'file-word',
        'xls' => 'file-excel',
        'xlsx' => 'file-excel',
        'jpg' => 'file-image',
        'jpeg' => 'file-image',
        'png' => 'file-image',
        'gif' => 'file-image',
        'zip' => 'file-archive',
        'rar' => 'file-archive',
        '7z' => 'file-archive',
        'gz' => 'file-archive',
        'tar' => 'file-archive',
        'txt' => 'file-text',
        'mp3' => 'file-audio',
        'mp4' => 'file-video',
        'php' => 'file-code',
        'html' => 'file-code',
        'css' => 'file-code',
        'js' => 'file-code',
    ];

    return isset($iconMap[$extension]) ? $iconMap[$extension] : 'file';
}

/**
 * Check if a file is viewable as text
 * 
 * @param string $filename Filename
 * @return bool True if viewable as text
 */
function isViewableFile($filename) {
    $viewableExtensions = ['txt', 'log', 'php', 'js', 'css', 'html', 'htm', 'xml', 'json', 'md', 'csv'];
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    
    return in_array($extension, $viewableExtensions);
}

/**
 * Check if a file is an image that can be displayed
 * 
 * @param string $filename Filename
 * @return bool True if file is displayable image
 */
function isDisplayableImage($filename) {
    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    
    return in_array($extension, $imageExtensions);
}

/**
 * Check if a file can be extracted (is archive)
 * 
 * @param string $filename Filename
 * @return bool True if file is extractable archive
 */
function isExtractableFile($filename) {
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    
    return $extension === 'zip';
}

/**
 * Validates a path to ensure it's within the base directory
 * 
 * @param string $path Path to validate
 * @param string $baseDir Base directory
 * @return bool True if path is valid
 */
function isValidPath($path, $baseDir) {
    if (!file_exists($path)) {
        return false;
    }
    
    return strpos(realpath($path), $baseDir) === 0;
}
?>