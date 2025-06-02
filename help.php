<?php
// Include required files
require_once 'includes/config.php';
require_once 'includes/file_utils.php';
require_once 'includes/session_manager.php';
require_once 'includes/breadcrumbs.php';
require_once 'includes/template_functions.php';
require_once 'includes/utils.php';

// Initialize session
$status = initializeSession();
$statusMessage = $status['statusMessage'];
$statusType = $status['statusType'];

// Get current directory for breadcrumb
$baseDir = BASE_DIR;
?>

<?php
// Set page specific variables before including header
$pageTitle = 'Help - Zen File Manager';
$breadcrumbLinks = ['help.php' => 'Help'];

// Include the header template
include 'includes/layout/header.php';
?>

<div class="page-content">
    <div class="content-section">
        <h2><i class="fas fa-question-circle"></i> Help & Documentation</h2>

        <div class="content-card">
            <div class="card-header">
                <h3>Getting Started</h3>
            </div>
            <div class="card-body">
                <p>Welcome to the Zen File Manager help section. This guide will walk you through the various features and operations available in the file manager.</p>

                <div class="help-toc">
                    <h4>Quick Navigation</h4>
                    <ul>
                        <li><a href="#navigation">Basic Navigation</a></li>
                        <li><a href="#file-operations">File Operations</a></li>
                        <li><a href="#upload-download">Uploading & Downloading</a></li>
                        <li><a href="#view-extract">Viewing & Extracting</a></li>
                        <li><a href="#bulk-operations">Bulk Operations</a></li>
                        <li><a href="#troubleshooting">Troubleshooting</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="navigation" class="content-card">
            <div class="card-header">
                <h3>Basic Navigation</h3>
            </div>
            <div class="card-body">
                <div class="help-item">
                    <div class="help-icon">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <div class="help-content">
                        <h4>Opening Folders</h4>
                        <p>Click on any folder to navigate into it. You can also double-click on folder cards.</p>
                        <div class="help-tip">
                            <i class="fas fa-lightbulb"></i>
                            <p>Tip: Folders are represented with a folder icon and indicate "Directory" in their description.</p>
                        </div>
                    </div>
                </div>

                <div class="help-item">
                    <div class="help-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="help-content">
                        <h4>Returning to Home</h4>
                        <p>Click on the "Home" link in the breadcrumb navigation at the top to return to the root directory.</p>
                    </div>
                </div>

                <div class="help-item">
                    <div class="help-icon">
                        <i class="fas fa-level-up-alt"></i>
                    </div>
                    <div class="help-content">
                        <h4>Going Up a Directory</h4>
                        <p>When browsing subdirectories, use the "Parent Directory" option to move up one level in the directory hierarchy.</p>
                    </div>
                </div>

                <div class="help-item">
                    <div class="help-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="help-content">
                        <h4>Searching for Files</h4>
                        <p>Use the search box to filter files and folders in the current directory. The search happens in real-time as you type.</p>
                    </div>
                </div>
            </div>
        </div>

        <div id="file-operations" class="content-card">
            <div class="card-header">
                <h3>File Operations</h3>
            </div>
            <div class="card-body">
                <div class="help-item">
                    <div class="help-icon">
                        <i class="fas fa-file"></i>
                    </div>
                    <div class="help-content">
                        <h4>Creating New Files</h4>
                        <p>Click the "New File" button, enter a name for your file in the popup modal, and click "Create".</p>
                        <div class="help-tip">
                            <i class="fas fa-lightbulb"></i>
                            <p>Tip: Include the file extension when creating a new file (e.g., "document.txt").</p>
                        </div>
                    </div>
                </div>

                <div class="help-item">
                    <div class="help-icon">
                        <i class="fas fa-folder-plus"></i>
                    </div>
                    <div class="help-content">
                        <h4>Creating New Folders</h4>
                        <p>Click the "New Folder" button, enter a name for your folder in the popup modal, and click "Create".</p>
                    </div>
                </div>

                <div class="help-item">
                    <div class="help-icon">
                        <i class="fas fa-edit"></i>
                    </div>
                    <div class="help-content">
                        <h4>Renaming Files and Folders</h4>
                        <p>Click the pencil icon on any file or folder, enter the new name in the popup modal, and click "Rename".</p>
                    </div>
                </div>

                <div class="help-item">
                    <div class="help-icon">
                        <i class="fas fa-trash"></i>
                    </div>
                    <div class="help-content">
                        <h4>Deleting Files and Folders</h4>
                        <p>Click the trash icon on any file or folder. You'll be asked to confirm before deletion.</p>
                        <div class="help-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <p>Warning: Deleting folders will remove all contents within them. This action cannot be undone.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="upload-download" class="content-card">
            <div class="card-header">
                <h3>Uploading & Downloading</h3>
            </div>
            <div class="card-body">
                <div class="help-item">
                    <div class="help-icon">
                        <i class="fas fa-upload"></i>
                    </div>
                    <div class="help-content">
                        <h4>Uploading Files</h4>
                        <p>Click the "Choose File" button in the upload section, select a file from your device, and click "Upload".</p>
                        <div class="help-tip">
                            <i class="fas fa-lightbulb"></i>
                            <p>Tip: Make sure you have navigated to the correct directory before uploading.</p>
                        </div>
                    </div>
                </div>

                <div class="help-item">
                    <div class="help-icon">
                        <i class="fas fa-download"></i>
                    </div>
                    <div class="help-content">
                        <h4>Downloading Files</h4>
                        <p>Click the download icon on any file to download it to your device.</p>
                    </div>
                </div>
            </div>
        </div>

        <div id="view-extract" class="content-card">
            <div class="card-header">
                <h3>Viewing & Extracting</h3>
            </div>
            <div class="card-body">
                <div class="help-item">
                    <div class="help-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <div class="help-content">
                        <h4>Viewing Files</h4>
                        <p>Click the eye icon on supported file types to view their contents directly in the browser.</p>
                        <div class="help-tip">
                            <i class="fas fa-lightbulb"></i>
                            <p>Tip: Text files, code files, and some document formats can be viewed in the browser.</p>
                        </div>
                    </div>
                </div>

                <div class="help-item">
                    <div class="help-icon">
                        <i class="fas fa-code"></i>
                    </div>
                    <div class="help-content">
                        <h4>Code Viewing</h4>
                        <p>Click the code icon on code files to view their source with proper formatting.</p>
                    </div>
                </div>

                <div class="help-item">
                    <div class="help-icon">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <div class="help-content">
                        <h4>Extracting ZIP Files</h4>
                        <p>Click the extraction icon on ZIP files to extract their contents to the current directory.</p>
                        <div class="help-tip">
                            <i class="fas fa-lightbulb"></i>
                            <p>Tip: A new folder will be created with the same name as the ZIP file.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="bulk-operations" class="content-card">
            <div class="card-header">
                <h3>Bulk Operations</h3>
            </div>
            <div class="card-body">
                <div class="help-item">
                    <div class="help-icon">
                        <i class="fas fa-copy"></i>
                    </div>
                    <div class="help-content">
                        <h4>Copying Multiple Files</h4>
                        <p>Click "File Operations" to enter selection mode, select the files/folders you want to copy, and click "Copy".</p>
                    </div>
                </div>

                <div class="help-item">
                    <div class="help-icon">
                        <i class="fas fa-cut"></i>
                    </div>
                    <div class="help-content">
                        <h4>Moving Multiple Files</h4>
                        <p>Click "File Operations" to enter selection mode, select the files/folders you want to move, and click "Cut".</p>
                    </div>
                </div>

                <div class="help-item">
                    <div class="help-icon">
                        <i class="fas fa-paste"></i>
                    </div>
                    <div class="help-content">
                        <h4>Pasting Files</h4>
                        <p>After copying or cutting files, navigate to the destination folder and click "Paste Here".</p>
                        <div class="help-tip">
                            <i class="fas fa-lightbulb"></i>
                            <p>Tip: The copy buffer is maintained until you clear it or perform a cut-and-paste operation.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="troubleshooting" class="content-card">
            <div class="card-header">
                <h3>Troubleshooting</h3>
            </div>
            <div class="card-body">
                <div class="help-item">
                    <div class="help-icon">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <div class="help-content">
                        <h4>Upload Errors</h4>
                        <p>If you cannot upload files, check that:</p>
                        <ul class="help-list">
                            <li>The file size is within your server's allowed limits</li>
                            <li>You have write permissions in the current directory</li>
                            <li>There's enough disk space available</li>
                        </ul>
                    </div>
                </div>

                <div class="help-item">
                    <div class="help-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="help-content">
                        <h4>Permission Issues</h4>
                        <p>If you cannot create, delete, or modify files and folders, it may be due to file system permissions. Contact your server administrator for assistance.</p>
                    </div>
                </div>

                <div class="help-item">
                    <div class="help-icon">
                        <i class="fas fa-bug"></i>
                    </div>
                    <div class="help-content">
                        <h4>Reporting Bugs</h4>
                        <p>If you encounter any bugs or unexpected behavior, please report them on our <a href="https://github.com/sculptorofcode/zen-file-manager/issues" target="_blank" class="link">GitHub Issues page</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="action-button">
    <a href="index.php" class="btn btn-primary">
        <i class="fas fa-arrow-left"></i> Back to File Manager
    </a>
</div>

<?php include 'includes/layout/footer.php'; ?>
</div>
</div>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/main.js"></script>
</body>

</html>