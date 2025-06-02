<?php
// Directory operation functions

/**
 * Get current directory path with validation
 * 
 * @param string $dirParam Directory parameter from GET request
 * @param string $baseDir Base directory
 * @return string Current directory path
 */
function getCurrentDir($dirParam, $baseDir) {
    $currentDir = isset($dirParam) ? realpath($baseDir . '/' . $dirParam) : $baseDir;
    
    // Prevent navigation outside the base directory
    if ($currentDir === false || strpos($currentDir, $baseDir) !== 0) {
        return $baseDir;
    }
    
    return $currentDir;
}

/**
 * Scan directory and return files and folders
 * 
 * @param string $dir Directory to scan
 * @return array List of files and directories
 */
function scanDirectory($dir) {
    return file_exists($dir) ? scandir($dir) : [];
}

/**
 * Add item to copy/cut buffer
 * 
 * @param array $selectedItems List of selected items
 * @param string $currentDir Current directory
 * @param string $baseDir Base directory
 * @param string $operation 'copy' or 'cut'
 * @return array Result with count and status
 */
function addToBuffer($selectedItems, $currentDir, $baseDir, $operation) {
    $_SESSION['copy_buffer'] = [];
    // Set the operation type
    $_SESSION['buffer_operation'] = $operation;
    
    $count = 0;
    foreach ($selectedItems as $item) {
        $itemPath = $currentDir . '/' . basename($item);
        
        // Validate path is within allowed directory
        if (file_exists($itemPath) && strpos(realpath($itemPath), $baseDir) === 0) {
            $_SESSION['copy_buffer'][] = [
                'name' => basename($item),
                'path' => $itemPath,
                'is_dir' => is_dir($itemPath)
            ];
            $count++;
        }
    }
    
    return [
        'count' => $count,
        'operation' => $operation
    ];
}

/**
 * Paste items from buffer to current directory
 * 
 * @param array $buffer Copy buffer from session
 * @param string $currentDir Current directory
 * @param string $operation 'copy' or 'cut'
 * @return array Result with counts and status
 */
function pasteFromBuffer($buffer, $currentDir, $operation) {
    $successCount = 0;
    $errorCount = 0;
    
    foreach ($buffer as $item) {
        $destPath = $currentDir . '/' . basename($item['name']);
        
        // Check if destination already exists
        if (!file_exists($destPath)) {
            $success = false;
            if ($item['is_dir']) {
                $success = copyDir($item['path'], $destPath);
            } else {
                $success = copy($item['path'], $destPath);
            }
            
            // If this is a cut operation and copy was successful, delete the original
            if ($success && $operation === 'cut') {
                if ($item['is_dir']) {
                    deleteDir($item['path']);
                } else {
                    unlink($item['path']);
                }
            }
            
            if ($success) {
                $successCount++;
            } else {
                $errorCount++;
            }
        } else {
            $errorCount++;
        }
    }
    
    // Clear buffer after cut operation
    if ($operation === 'cut') {
        $_SESSION['copy_buffer'] = [];
        $_SESSION['buffer_operation'] = null;
    }
    
    return [
        'successCount' => $successCount,
        'errorCount' => $errorCount,
        'operation' => $operation
    ];
}
?>