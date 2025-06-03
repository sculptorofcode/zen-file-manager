<?php
// Include all required files
require_once 'includes/config.php';
require_once 'includes/file_utils.php';
require_once 'includes/file_operations.php';
require_once 'includes/dir_operations.php';
require_once 'includes/session_manager.php';
require_once 'includes/breadcrumbs.php';
require_once 'includes/template_functions.php';
require_once 'includes/utils.php';

// Get current directory and validate it
$baseDir = BASE_DIR;
$currentDir = getCurrentDir($_GET['dir'] ?? null, $baseDir);

// Initialize session and get any status messages
$status = initializeSession();
$statusMessage = $status['statusMessage'];
$statusType = $status['statusType'];

// Get the list of files and directories in the current directory
$files = scandir($currentDir);

// Handle file or folder deletion
if (isset($_GET['delete'])) {
    $result = handleDeleteItem($_GET['delete'], $currentDir, $baseDir);

    // Store messages in session to display after redirect
    setStatusMessage($result['statusMessage'], $result['statusType']);

    redirectTo(getCurrentUrlWithDir([], ['delete']));
}

// Handle adding items to copy/cut buffer
if ((isset($_POST['copy_items']) || isset($_POST['cut_items'])) && !empty($_POST['selected_items'])) {
    $operation = isset($_POST['copy_items']) ? 'copy' : 'cut';
    handleCopyBuffer($_POST['selected_items'], $operation, $currentDir, $baseDir);

    redirectTo(getCurrentUrlWithDir());
}

// Handle pasting copied/cut items
if (isset($_POST['paste_items']) && !empty($_SESSION['copy_buffer'])) {
    $operation = $_SESSION['buffer_operation'] ?? 'copy';
    $result = handlePasteItems($_SESSION['copy_buffer'], $currentDir, $operation);

    // Clear buffer after cut operation
    if ($operation === 'cut') {
        clearCopyBuffer();
    }

    // Store messages in session to display after redirect
    setStatusMessage($result['statusMessage'], $result['statusType']);

    redirectTo(getCurrentUrlWithDir());
}

// Handle clearing copy buffer
if (isset($_POST['clear_buffer'])) {
    clearCopyBuffer();

    redirectTo(getCurrentUrlWithDir());
}

// Handle creating new file or folder
if (isset($_POST['create_type']) && isset($_POST['create_name'])) {
    $result = handleCreateItem($_POST['create_name'], $_POST['create_type'], $currentDir, $baseDir);

    // Store messages in session to display after redirect
    setStatusMessage($result['statusMessage'], $result['statusType']);

    redirectTo(getCurrentUrlWithDir());
}

// Handle file rename
if (isset($_GET['rename']) && isset($_POST['new_name'])) {
    $result = handleRenameItem($_GET['rename'], $_POST['new_name'], $currentDir, $baseDir);

    // Store messages in session to display after redirect
    setStatusMessage($result['statusMessage'], $result['statusType']);

    redirectTo(getCurrentUrlWithDir());
}

// Handle ZIP extraction
if (isset($_GET['extract'])) {
    $result = handleZipExtraction($_GET['extract'], $currentDir);

    if (!$result['success'] && $result['error']) {
        $extractError = $result['error'];
    } else {
        // Redirect but clear the extract parameter to prevent loop
        redirectTo(generateUrl(['dir' => $_GET['dir'] ?? ''], ['extract']));
    }
}

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    if (handleFileUpload($_FILES['file'], $currentDir)) {
        redirectTo(getCurrentUrlWithDir());
    } else {
        $uploadError = true;
    }
}

// Handle file viewing
if (isset($_GET['view'])) {
    $result = handleFileView($_GET['view'], $currentDir, $baseDir);
    $fileContent = $result['fileContent'];
    $viewingFile = $result['viewingFile'];
}

// Handle file rendering
if (isset($_GET['render'])) {
    $renderedFile = handleFileRender($_GET['render'], $currentDir, $baseDir);
}

// Generate breadcrumb navigation
$breadcrumbs = generateBreadcrumbs($currentDir, $baseDir);

// Set the page title
$pageTitle = 'Zen File Manager';
$additionalHeadContent = addJsVariables($_SESSION['copy_buffer'] ?? [], $_SESSION['buffer_operation'] ?? null);
$breadcrumbHtml = renderBreadcrumbs($breadcrumbs);

// Include header
require_once 'includes/layout/header.php';
?>

<div class="action-bar">
    <div class="upload-section">
        <form method="post" enctype="multipart/form-data" class="upload-form">
            <div class="custom-file-upload">
                <input type="file" name="file" required id="file-upload-input" class="file-input">
                <label for="file-upload-input" class="file-upload-label">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <span class="upload-text">Choose File</span>
                </label>
            </div>
            <button type="submit" class="btn btn-primary upload-btn">
                <i class="fas fa-upload"></i> Upload
            </button>
        </form>
    </div>

    <div class="create-buttons">
        <button onclick="showCreateForm('file')" class="btn create-file-btn">
            <i class="fas fa-file"></i> New File
        </button>
        <button onclick="showCreateForm('folder')" class="btn create-folder-btn">
            <i class="fas fa-folder-plus"></i> New Folder
        </button>
        <button onclick="toggleSelectionMode()" id="selection-mode-btn" class="btn btn-light selection-btn">
            <i class="fas fa-copy"></i> File Operations
        </button>
    </div>
</div>

<?php if (!empty($_SESSION['buffer_operation'])): ?>
    <!-- Bulk operation panel, hidden by default -->
    <div id="bulk-op-panel" class="bulk-op-panel <?php echo (!empty($_SESSION['buffer_operation']) ? $_SESSION['buffer_operation'] . '-mode' : ''); ?>" style="display: none;">
        <form method="post" id="bulk-form">
            <div class="bulk-info">
                <span id="selected-count">0 items selected</span>
                <?php if (!empty($_SESSION['copy_buffer'])): ?>
                    <span class="buffer-info">(<?php echo count($_SESSION['copy_buffer']); ?> items in buffer - <?php echo $_SESSION['buffer_operation'] === 'cut' ? 'Cut' : 'Copy'; ?> mode)</span>
                <?php endif; ?>
            </div>
            <div class="bulk-buttons">
                <button type="submit" name="copy_items" class="btn btn-light copy-btn">
                    <i class="fas fa-copy"></i> Copy
                </button>
                <button type="submit" name="cut_items" class="btn btn-light cut-btn">
                    <i class="fas fa-cut"></i> Cut
                </button>
                <?php if (!empty($_SESSION['copy_buffer'])): ?>
                    <button type="button" onclick="confirmPaste()" class="btn btn-primary paste-btn">
                        <i class="fas fa-paste"></i> Paste Here
                    </button>
                    <button type="submit" name="clear_buffer" class="btn btn-danger clear-btn">
                        <i class="fas fa-times"></i> Clear Buffer
                    </button>
                    <input type="hidden" name="paste_items" id="paste_items_input" disabled>
                <?php endif; ?>
                <button type="button" onclick="cancelSelection()" class="btn btn-light cancel-btn">
                    <i class="fas fa-times-circle"></i> Cancel
                </button>
            </div>
            <div id="selected-items-container"></div>
        </form>
    </div>
<?php endif; ?>

<div class="search-section">
    <form method="get" class="search-form" onsubmit="return false;">
        <input
            type="text"
            id="search-input"
            placeholder="Search files or folders..."
            class="search-input"
            oninput="filterFiles()">
    </form>
</div>

<?php if (isset($uploadError)): ?>
    <div class="status-message status-error">
        <i class="fas fa-exclamation-circle"></i> Failed to upload file.
    </div>
<?php endif; ?>

<?php if (isset($extractError)): ?>
    <div class="status-message status-error">
        <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($extractError); ?>
    </div>
<?php endif; ?>

<?php if ($statusMessage): ?>
    <?php $icon = $statusType === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle'; ?>
    <div class="status-message status-<?php echo $statusType; ?>">
        <i class="<?php echo $icon; ?>"></i> <?php echo htmlspecialchars($statusMessage); ?>
    </div>
<?php endif; ?>

<?php if (isset($fileContent)): ?>
    <div class="file-viewer">
        <h2>Viewing File: <?php echo htmlspecialchars($viewingFile); ?></h2>
        <div class="file-content">
            <pre><?php echo htmlspecialchars($fileContent); ?></pre>
        </div>
    </div>
<?php endif; ?>

<?php if (isset($renderedFile)): ?>
    <div class="file-renderer">
        <h2>Rendered Output: <?php echo htmlspecialchars(basename($renderedFile)); ?></h2>
        <iframe src="<?php echo htmlspecialchars($renderedFile); ?>" frameborder="0" style="width: 100%; height: 500px;"></iframe>
    </div>
<?php endif; ?> <div class="files-container">
    <div class="files-header">
        <span><i class="fas fa-folder-open"></i> Files &amp; Folders</span>
        <span class="file-count"><?php echo count($files) - 2; ?> items</span>
    </div>

    <div class="files-grid">
        <?php if ($currentDir !== $baseDir): ?>
            <div class="file-card special-card non-selectable">
                <div class="file-icon">
                    <i class="fas fa-level-up-alt"></i>
                </div>
                <a href="?dir=<?php echo urlencode(dirname($_GET['dir'] ?? '')); ?>"
                    class="text-white" data-tooltip="Go Up">
                    <div class="file-name">Parent Directory</div>
                </a>
                <div class="file-actions">
                    <a href="?dir=<?php echo urlencode(dirname($_GET['dir'] ?? '')); ?>"
                        class="file-action-btn" data-tooltip="Go Up">
                        <i class="fas fa-arrow-up"></i>
                    </a>
                </div>
            </div>
        <?php endif; ?>

        <?php
        foreach ($files as $file):
            if ($file === '.' || $file == '..') continue;

            // Apply search filter
            if (isset($_GET['search']) && $_GET['search'] !== '') {
                if (stripos($file, $_GET['search']) === false) continue; // Skip files not matching the search
            }

            $filePath = $currentDir . '/' . $file;
            $fileType = is_dir($filePath) ? 'folder' : getFileTypeClass($file);
            include 'includes/layout/file-card.php';
        endforeach;
        ?>
    </div>
</div>
<?php include 'includes/layout/footer.php'; ?>
</div>
</div>

<!-- Rename Modal -->
<div id="renameModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Rename <span id="renameItemType">File</span></h3>
            <span class="close" onclick="closeRenameModal()">&times;</span>
        </div>
        <form id="renameForm" method="post" class="rename-form">
            <input type="text" id="newName" name="new_name" class="rename-input" required>
            <div class="rename-buttons">
                <button type="button" class="btn btn-light rename-cancel" onclick="closeRenameModal()">Cancel</button>
                <button type="submit" class="btn btn-primary rename-submit">Rename</button>
            </div>
        </form>
    </div>
</div>

<!-- Create Modal -->
<div id="createModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Create New <span id="createItemType">File</span></h3>
            <span class="close" onclick="closeCreateModal()">&times;</span>
        </div>
        <form id="createForm" method="post" class="rename-form">
            <input type="hidden" id="createType" name="create_type" value="file">
            <input type="text" id="createName" name="create_name" class="rename-input" required placeholder="Enter name...">
            <div class="rename-buttons">
                <button type="button" class="btn btn-light rename-cancel" onclick="closeCreateModal()">Cancel</button>
                <button type="submit" class="btn btn-primary rename-submit">Create</button>
            </div>
        </form>
    </div>
</div>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/main.js"></script>
</body>

</html>