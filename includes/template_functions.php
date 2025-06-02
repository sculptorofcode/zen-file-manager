<?php
// Functions for rendering templates and UI components

/**
 * Render file actions
 * 
 * @param string $filename Filename
 * @param boolean $isDir Whether the item is a directory
 * @param string $currentDir Current directory relative path for URLs
 * @return string HTML for file actions
 */
function renderFileActions($filename, $isDir, $currentDir) {
    $encodedName = urlencode($filename);
    $encodedCurrentDir = urlencode($currentDir);
    
    $html = '<div class="file-actions">';
    
    if (!$isDir) {
        // Download link
        $html .= '<a href="download.php?file=' . $encodedName . '&dir=' . $encodedCurrentDir . '" class="file-action-btn download-btn" title="Download"><i class="fas fa-download"></i></a>';
        
        // View link for viewable files
        if (isViewableFile($filename)) {
            $html .= '<a href="?dir=' . $encodedCurrentDir . '&view=' . $encodedName . '" class="file-action-btn view-btn" title="View"><i class="fas fa-eye"></i></a>';
        }
        
        // Extract link for zip files
        if (isExtractableFile($filename)) {
            $html .= '<a href="?dir=' . $encodedCurrentDir . '&extract=' . $encodedName . '" class="file-action-btn extract-btn" title="Extract"><i class="fas fa-box-open"></i></a>';
        }
    }
    
    // Rename link
    $html .= '<a href="javascript:void(0)" onclick="showRenameForm(\'' . htmlspecialchars(addslashes($filename), ENT_QUOTES) . '\', ' . ($isDir ? 'true' : 'false') . ')" class="file-action-btn rename-btn" title="Rename"><i class="fas fa-edit"></i></a>';
    
    // Delete link
    $html .= '<a href="?dir=' . $encodedCurrentDir . '&delete=' . $encodedName . '" class="file-action-btn delete-btn" title="Delete" onclick="return confirm(\'Are you sure you want to delete this ' . ($isDir ? 'folder' : 'file') . '?\')"><i class="fas fa-trash"></i></a>';
    
    $html .= '</div>';
    
    return $html;
}

/**
 * Render file/folder card
 * 
 * @param string $filename Filename
 * @param string $currentDir Current directory
 * @param string $baseDir Base directory
 * @return string HTML for file/folder card
 */
function renderFileCard($filename, $currentDir, $baseDir) {
    // Skip . and ..
    if ($filename === '.' || $filename === '..') {
        return '';
    }
    
    $filePath = $currentDir . '/' . $filename;
    $isDir = is_dir($filePath);
    $relativeDir = str_replace($baseDir, '', $currentDir);
    if ($relativeDir === '') $relativeDir = '/';
    
    $html = '<div class="file-card" onclick="toggleItemSelection(event)" ondblclick="' . ($isDir ? 'window.location=\'?dir=' . urlencode($relativeDir . '/' . $filename) . '\'' : '') . '">';
    $html .= '<div class="selection-indicator"><i class="fas fa-check-circle"></i></div>';
    
    if ($isDir) {
        $html .= '<div class="file-icon"><i class="fas fa-folder"></i></div>';
        $html .= '<div class="file-name">' . htmlspecialchars($filename) . '</div>';
        $html .= '<div class="file-info">Directory</div>';
    } else {
        $filesize = filesize($filePath);
        $icon = getFileIcon($filename);
        
        $html .= '<div class="file-icon"><i class="fas fa-' . $icon . '"></i></div>';
        $html .= '<div class="file-name">' . htmlspecialchars($filename) . '</div>';
        $html .= '<div class="file-info">' . humanFilesize($filesize) . '</div>';
    }
    
    $html .= renderFileActions($filename, $isDir, $relativeDir);
    $html .= '</div>';
    
    return $html;
}

/**
 * Render modals (rename, create, etc.)
 * 
 * @return string HTML for modals
 */
function renderModals() {
    // Rename modal
    $html = '<div id="renameModal" class="modal">';
    $html .= '<div class="modal-content">';
    $html .= '<div class="modal-header">';
    $html .= '<h3>Rename <span id="renameItemType">File</span></h3>';
    $html .= '<span class="close" onclick="closeRenameModal()">&times;</span>';
    $html .= '</div>';
    $html .= '<form id="renameForm" method="post" class="rename-form">';
    $html .= '<input type="text" id="newName" name="new_name" class="rename-input" required>';
    $html .= '<div class="rename-buttons">';
    $html .= '<button type="button" onclick="closeRenameModal()" class="rename-cancel">Cancel</button>';
    $html .= '<button type="submit" class="rename-submit">Rename</button>';
    $html .= '</div>';
    $html .= '</form>';
    $html .= '</div>';
    $html .= '</div>';
    
    // Create modal
    $html .= '<div id="createModal" class="modal">';
    $html .= '<div class="modal-content">';
    $html .= '<div class="modal-header">';
    $html .= '<h3>Create New <span id="createItemType">File</span></h3>';
    $html .= '<span class="close" onclick="closeCreateModal()">&times;</span>';
    $html .= '</div>';
    $html .= '<form id="createForm" method="post" class="rename-form">';
    $html .= '<input type="hidden" id="createType" name="create_type" value="file">';
    $html .= '<input type="text" id="createName" name="create_name" class="rename-input" required>';
    $html .= '<div class="rename-buttons">';
    $html .= '<button type="button" onclick="closeCreateModal()" class="rename-cancel">Cancel</button>';
    $html .= '<button type="submit" class="rename-submit">Create</button>';
    $html .= '</div>';
    $html .= '</form>';
    $html .= '</div>';
    $html .= '</div>';
    
    return $html;
}

/**
 * Render status message
 * 
 * @param string $message Message content
 * @param string $type Message type (success, error)
 * @return string HTML for status message
 */
function renderStatusMessage($message, $type) {
    if (empty($message)) {
        return '';
    }
    
    $icon = $type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';
    
    return '<div class="status-message status-' . $type . '">
        <i class="' . $icon . '"></i> ' . htmlspecialchars($message) . '
    </div>';
}

/**
 * Generate JavaScript for initializing the cut buffer items
 * 
 * @param array $copyBuffer The copy buffer from session
 * @param string $bufferOperation The buffer operation ('cut' or 'copy')
 * @return string JavaScript initialization code
 */
function generateCutBufferJS($copyBuffer, $bufferOperation) {
    if (empty($copyBuffer)) {
        return '';
    }
    
    $items = array_map(function($item) {
        return $item['name'];
    }, $copyBuffer);
    
    $itemsJSON = json_encode($items);
    $count = count($copyBuffer);
    
    return "
        <script>
            const cutBufferItems = {$itemsJSON};
            const cutBufferMode = '{$bufferOperation}';
            const cutBufferItemCount = {$count};
        </script>
    ";
}

/**
 * Add JavaScript variables to the page
 * 
 * @param array $copyBuffer The copy buffer from session
 * @param string $bufferOperation The buffer operation ('cut' or 'copy')
 * @return string HTML script tag with JS variables
 */
function addJsVariables($copyBuffer = [], $bufferOperation = null) {
    return generateCutBufferJS($copyBuffer, $bufferOperation);
}
?>