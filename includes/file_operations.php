<?php
// File operation functions

/**
 * Delete a file
 * 
 * @param string $filePath Path to the file
 * @return bool True if deletion was successful, false otherwise
 */
function deleteFile($filePath) {
    if (!file_exists($filePath) || is_dir($filePath)) {
        return false;
    }
    
    return unlink($filePath);
}

/**
 * Recursively delete a directory
 * 
 * @param string $dirPath Path to the directory
 * @return bool True if deletion was successful, false otherwise
 */
function deleteDir($dirPath) {
    if (!is_dir($dirPath)) {
        return false;
    }
    $files = array_diff(scandir($dirPath), ['.', '..']);
    foreach ($files as $file) {
        $path = $dirPath . '/' . $file;
        if (is_dir($path)) {
            deleteDir($path);
        } else {
            unlink($path);
        }
    }
    return rmdir($dirPath);
}

/**
 * Recursively copy a directory
 * 
 * @param string $src Source directory path
 * @param string $dst Destination directory path
 * @return bool True if copy was successful, false otherwise
 */
function copyDir($src, $dst) {
    $dir = opendir($src);
    if (!file_exists($dst)) {
        if (!mkdir($dst, 0755, true)) {
            return false;
        }
    }
    
    while (($file = readdir($dir)) !== false) {
        if ($file != '.' && $file != '..') {
            $srcFile = $src . '/' . $file;
            $dstFile = $dst . '/' . $file;
            if (is_dir($srcFile)) {
                copyDir($srcFile, $dstFile);
            } else {
                copy($srcFile, $dstFile);
            }
        }
    }
    closedir($dir);
    return true;
}

/**
 * Rename a file or folder
 * 
 * @param string $oldPath Current path
 * @param string $newPath New path
 * @return bool True if rename was successful, false otherwise
 */
function renameItem($oldPath, $newPath) {
    if (!file_exists($oldPath) || file_exists($newPath)) {
        return false;
    }
    
    return rename($oldPath, $newPath);
}

/**
 * Create a new file
 * 
 * @param string $path Path to create file
 * @return bool True if creation was successful, false otherwise
 */
function createFile($path) {
    if (file_exists($path)) {
        return false;
    }
    
    return touch($path);
}

/**
 * Create a new folder
 * 
 * @param string $path Path to create folder
 * @return bool True if creation was successful, false otherwise
 */
function createFolder($path) {
    if (file_exists($path)) {
        return false;
    }
    
    return mkdir($path, 0755);
}

/**
 * Extract a ZIP file
 * 
 * @param string $zipFile Path to ZIP file
 * @param string $extractPath Path to extract to
 * @return array Result array with status and message
 */
function extractZip($zipFile, $extractPath) {
    if (!file_exists($zipFile) || pathinfo($zipFile, PATHINFO_EXTENSION) !== 'zip') {
        return [
            'success' => false,
            'message' => 'Invalid ZIP file.'
        ];
    }
    
    $zip = new ZipArchive;
    if ($zip->open($zipFile) === TRUE) {
        // Create directory if it doesn't exist
        if (!file_exists($extractPath)) {
            mkdir($extractPath, 0755, true);
        }
        
        // Extract ZIP contents
        $zip->extractTo($extractPath);
        $zip->close();
        
        return [
            'success' => true,
            'message' => 'File extracted successfully.'
        ];
    }
    
    return [
        'success' => false,
        'message' => 'Failed to open ZIP file.'
    ];
}

/**
 * Upload a file
 * 
 * @param array $fileData File data from $_FILES
 * @param string $destination Target path
 * @return bool True if upload was successful, false otherwise
 */
function uploadFile($fileData, $destination) {
    if (!isset($fileData['tmp_name']) || !isset($fileData['name'])) {
        return false;
    }
    
    return move_uploaded_file($fileData['tmp_name'], $destination);
}

/**
 * Handle pasting files and directories from buffer
 * 
 * @param array $copyBuffer The copy buffer containing items to paste
 * @param string $currentDir The current directory to paste into
 * @param string $operation The buffer operation ('copy' or 'cut')
 * @return array Result containing success count, error count and operation type
 */
function handlePasteItems($copyBuffer, $currentDir, $operation) {
    $successCount = 0;
    $errorCount = 0;
    
    foreach ($copyBuffer as $item) {
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
    
    $verb = $operation === 'copy' ? 'copied' : 'moved';
    
    if ($errorCount == 0) {
        $message = "$successCount item" . ($successCount > 1 ? 's' : '') . " $verb successfully.";
        $statusType = "success";
    } else if ($successCount == 0) {
        $message = "Failed to $verb items. Destination files may already exist.";
        $statusType = "error";
    } else {
        $message = "$successCount item" . ($successCount > 1 ? 's' : '') . " $verb. $errorCount item" . ($errorCount > 1 ? 's' : '') . " failed.";
        $statusType = "error";
    }
    
    return [
        'statusMessage' => $message,
        'statusType' => $statusType,
        'successCount' => $successCount,
        'errorCount' => $errorCount
    ];
}

/**
 * Handle file upload
 * 
 * @param array $fileData The $_FILES array data for the upload
 * @param string $currentDir The directory to upload to
 * @return bool True if upload was successful, false otherwise
 */
function handleFileUpload($fileData, $currentDir) {
    $targetPath = $currentDir . '/' . basename($fileData['name']);
    return move_uploaded_file($fileData['tmp_name'], $targetPath);
}

/**
 * Handle ZIP extraction
 * 
 * @param string $zipFileName The name of the ZIP file to extract
 * @param string $currentDir The current directory
 * @return array Result containing success status and error message if any
 */
function handleZipExtraction($zipFileName, $currentDir) {
    $zipFile = $currentDir . '/' . basename($zipFileName);
    $result = [
        'success' => false,
        'error' => null
    ];
    
    if (file_exists($zipFile) && pathinfo($zipFile, PATHINFO_EXTENSION) === 'zip') {
        $zip = new ZipArchive;
        if ($zip->open($zipFile) === TRUE) {
            // Create extraction directory (use zip file name without extension)
            $extractDir = $currentDir . '/' . pathinfo(basename($zipFile), PATHINFO_FILENAME);
            
            // Create directory if it doesn't exist
            if (!file_exists($extractDir)) {
                mkdir($extractDir, 0755, true);
            }
            
            // Extract ZIP contents
            $zip->extractTo($extractDir);
            $zip->close();
            
            $result['success'] = true;
        } else {
            $result['error'] = "Failed to open ZIP file.";
        }
    } else {
        $result['error'] = "Invalid ZIP file.";
    }
    
    return $result;
}

/**
 * Handle creating a new file or folder
 * 
 * @param string $createName The name of the file or folder to create
 * @param string $createType The type ('file' or 'folder')
 * @param string $currentDir The current directory
 * @param string $baseDir The base directory
 * @return array Result with status message and type
 */
function handleCreateItem($createName, $createType, $currentDir, $baseDir) {
    $createPath = $currentDir . '/' . basename($createName);
    $itemName = basename($createName);
    
    // Validate the path is within base directory and name is valid
    if (strpos($currentDir, $baseDir) !== 0 || basename($createName) === '') {
        return [
            'statusMessage' => 'Invalid name or path.',
            'statusType' => 'error'
        ];
    }
    
    // Check if it doesn't already exist
    if (file_exists($createPath)) {
        return [
            'statusMessage' => "Cannot create: a file or folder with this name already exists.",
            'statusType' => 'error'
        ];
    }
    
    if ($createType === 'folder') {
        // Create folder
        $success = mkdir($createPath, 0755);
        if ($success) {
            return [
                'statusMessage' => "Folder '{$itemName}' created successfully.",
                'statusType' => 'success'
            ];
        } else {
            return [
                'statusMessage' => "Failed to create folder '{$itemName}'. Check permissions.",
                'statusType' => 'error'
            ];
        }
    } else {
        // Create empty file
        $success = touch($createPath);
        if ($success) {
            return [
                'statusMessage' => "File '{$itemName}' created successfully.",
                'statusType' => 'success'
            ];
        } else {
            return [
                'statusMessage' => "Failed to create file '{$itemName}'. Check permissions.",
                'statusType' => 'error'
            ];
        }
    }
}

/**
 * Handle renaming a file or folder
 * 
 * @param string $fileToRename Name of the file to rename
 * @param string $newName New name for the file
 * @param string $currentDir Current directory
 * @param string $baseDir Base directory
 * @return array Status message and type
 */
function handleRenameItem($fileToRename, $newName, $currentDir, $baseDir) {
    $filePath = $currentDir . '/' . basename($fileToRename);
    $newPath = $currentDir . '/' . basename($newName);
    $itemName = basename($filePath);
    
    // Ensure we're not renaming to something that already exists or outside base directory
    if (!file_exists($filePath) || 
        strpos(realpath($filePath), $baseDir) !== 0 || 
        strpos($currentDir, $baseDir) !== 0 ||
        basename($newName) === '') {
        
        return [
            'statusMessage' => 'Invalid file or directory name.',
            'statusType' => 'error'
        ];
    }
    
    if (file_exists($newPath)) {
        return [
            'statusMessage' => "Cannot rename: a file or folder with this name already exists.",
            'statusType' => 'error'
        ];
    }
    
    if (rename($filePath, $newPath)) {
        return [
            'statusMessage' => "Successfully renamed '{$itemName}' to '" . basename($newName) . "'.",
            'statusType' => 'success'
        ];
    } else {
        return [
            'statusMessage' => "Failed to rename '{$itemName}'. Check file permissions.",
            'statusType' => 'error'
        ];
    }
}

/**
 * Handle file viewing
 * 
 * @param string $fileToView Name of file to view
 * @param string $currentDir Current directory
 * @param string $baseDir Base directory
 * @return array File content and name if successful, null otherwise
 */
function handleFileView($fileToView, $currentDir, $baseDir) {
    $filePath = $currentDir . '/' . basename($fileToView);

    // Validate that the file exists and is within the allowed directory
    if (file_exists($filePath) && strpos(realpath($filePath), $baseDir) === 0) {
        return [
            'fileContent' => file_get_contents($filePath),
            'viewingFile' => basename($filePath)
        ];
    }
    
    return [
        'fileContent' => null,
        'viewingFile' => null
    ];
}

/**
 * Handle file rendering
 * 
 * @param string $fileToRender Name of file to render
 * @param string $currentDir Current directory
 * @param string $baseDir Base directory
 * @return string|null Path to the rendered file relative to base dir, or null if invalid
 */
function handleFileRender($fileToRender, $currentDir, $baseDir) {
    $filePath = $currentDir . '/' . basename($fileToRender);
    
    // Validate the file path
    if (file_exists($filePath) && strpos(realpath($filePath), $baseDir) === 0) {
        return str_replace($baseDir, '', realpath($filePath));
    }
    
    return null;
}

/**
 * Handle file or folder deletion
 * 
 * @param string $itemToDelete Name of the item to delete
 * @param string $currentDir Current directory
 * @param string $baseDir Base directory
 * @return array Status message and type
 */
function handleDeleteItem($itemToDelete, $currentDir, $baseDir) {
    $pathToDelete = $currentDir . '/' . basename($itemToDelete);
    $itemName = basename($pathToDelete);
    $isDir = is_dir($pathToDelete);
    
    // Ensure we're not deleting the base directory or going outside of it
    if (!file_exists($pathToDelete) || strpos(realpath($pathToDelete), $baseDir) !== 0 || realpath($pathToDelete) === $baseDir) {
        return [
            'statusMessage' => "Access denied or invalid deletion attempt.",
            'statusType' => "error"
        ];
    }
    
    // Check if it's a directory or a file
    if ($isDir) {
        $success = deleteDir($pathToDelete);
        if ($success) {
            return [
                'statusMessage' => "Folder '{$itemName}' and all its contents deleted successfully.",
                'statusType' => "success"
            ];
        } else {
            return [
                'statusMessage' => "Failed to delete folder '{$itemName}'. It may not be empty or you may not have permissions.",
                'statusType' => "error"
            ];
        }
    } else {
        // It's a file, use unlink
        $success = deleteFile($pathToDelete);
        if ($success) {
            return [
                'statusMessage' => "File '{$itemName}' deleted successfully.",
                'statusType' => "success"
            ];
        } else {
            return [
                'statusMessage' => "Failed to delete file '{$itemName}'. Check file permissions.",
                'statusType' => "error"
            ];
        }
    }
}
?>