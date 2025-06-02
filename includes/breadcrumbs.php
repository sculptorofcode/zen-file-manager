<?php
// Breadcrumb navigation functions

/**
 * Generate breadcrumb navigation
 * 
 * @param string $currentDir Current directory
 * @param string $baseDir Base directory
 * @return array Array of breadcrumb HTML links
 */
function generateBreadcrumbs($currentDir, $baseDir) {
    $breadcrumbs = [];
    $path = '';
    foreach (explode(DIRECTORY_SEPARATOR, str_replace($baseDir, '', $currentDir)) as $part) {
        if ($part !== '') {
            $path .= ($path ? DIRECTORY_SEPARATOR : '') . $part;
            $breadcrumbs[] = "<a href='?dir=" . urlencode($path) . "'>" . htmlspecialchars($part) . "</a>";
        }
    }
    
    return $breadcrumbs;
}

/**
 * Render breadcrumbs as HTML
 * 
 * @param array $breadcrumbs Array of breadcrumb links
 * @return string HTML for breadcrumb navigation
 */
function renderBreadcrumbs($breadcrumbs) {
    $html = '<a href="?"><i class="fas fa-home"></i> Home</a>';
    
    if (!empty($breadcrumbs)) {
        $html .= '<span>/</span>' . implode('<span>/</span>', $breadcrumbs);
    }
    
    return $html;
}
?>