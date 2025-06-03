<?php
$relativePath = str_replace('\\', '/', str_replace($baseDir, '', $filePath));
$relativePath = ltrim($relativePath, '/');
$downloadUrl = rtrim(BASE_URL, '/') . '/' . $relativePath;
?>

<div class="file-card file-type-<?php echo $fileType; ?>" data-name="<?php echo htmlspecialchars($file); ?>">
    <div class="selection-indicator">
        <i class="fas fa-check-circle"></i>
    </div>
    <div class="file-icon">
        <?php if (is_dir($filePath)): ?>
            <i class="fas fa-folder"></i>
        <?php else: ?>
            <i class="fas fa-<?php echo getFileIcon($file); ?>"></i>
        <?php endif; ?>
    </div>
    <?php if (is_dir($filePath)): ?>
        <a href="?dir=<?php echo urlencode((isset($_GET['dir']) ? $_GET['dir'] . '/' : '') . $file); ?>"
            class="text-white" data-tooltip="Open">
            <div class="file-name"><?php echo htmlspecialchars($file); ?></div>
        </a>
    <?php else: ?>
        <?php if (strtolower(pathinfo($file, PATHINFO_EXTENSION)) !== 'zip'): ?>
            <a href="?dir=<?php echo urlencode($_GET['dir'] ?? ''); ?>&render=<?php echo urlencode($file); ?>"
                class="text-white" data-tooltip="View">
                <div class="file-name"><?php echo htmlspecialchars($file); ?></div>
            </a>
        <?php else: ?>
            <div class="file-name"><?php echo htmlspecialchars($file); ?></div>
        <?php endif; ?>
    <?php endif; ?>
    <?php if (!is_dir($filePath)): ?>
        <div class="file-info">
            <?php echo humanFilesize(filesize($filePath)); ?>
        </div>
    <?php else: ?>
        <div class="file-info">
            Directory
        </div>
    <?php endif; ?>
    <div class="file-actions">
        <?php if (is_dir($filePath)): ?>
            <a href="?dir=<?php echo urlencode((isset($_GET['dir']) ? $_GET['dir'] . '/' : '') . $file); ?>"
                class="file-action-btn" data-tooltip="Open">
                <i class="fas fa-folder-open"></i>
            </a>
            <button class="file-action-btn" data-tooltip="Rename"
                onclick="showRenameForm('<?php echo htmlspecialchars(addslashes($file)); ?>', true)">
                <i class="fas fa-pencil-alt"></i>
            </button>
            <a href="?dir=<?php echo urlencode($_GET['dir'] ?? ''); ?>&delete=<?php echo urlencode($file); ?>"
                class="file-action-btn" data-tooltip="Delete"
                onclick="return confirm('Are you sure you want to delete this folder and ALL its contents? This cannot be undone!')">
                <i class="fas fa-trash"></i>
            </a>
        <?php else: ?>
            <?php if (strtolower(pathinfo($file, PATHINFO_EXTENSION)) !== 'zip'): ?>
                <?php
                $imgExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg', 'ico'];
                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                if (!in_array($ext, $imgExtensions)):
                ?>
                    <a href="?dir=<?php echo urlencode($_GET['dir'] ?? ''); ?>&view=<?php echo urlencode($file); ?>"
                        class="file-action-btn" data-tooltip="Code">
                        <i class="fas fa-code"></i>
                    </a>
                <?php endif; ?>
                <a href="?dir=<?php echo urlencode($_GET['dir'] ?? ''); ?>&render=<?php echo urlencode($file); ?>"
                    class="file-action-btn" data-tooltip="View">
                    <i class="fas fa-eye"></i>
                </a>
            <?php endif; ?>
            <a href="<?= htmlspecialchars($downloadUrl); ?>" class="file-action-btn" data-tooltip="Download" download>
                <i class="fas fa-download"></i>
            </a>
            <?php if (strtolower(pathinfo($file, PATHINFO_EXTENSION)) === 'zip'): ?>
                <a href="?dir=<?php echo urlencode($_GET['dir'] ?? ''); ?>&extract=<?php echo urlencode($file); ?>"
                    class="file-action-btn" data-tooltip="Extract"
                    onclick="return confirm('Extract this ZIP file?')">
                    <i class="fas fa-file-archive"></i>
                </a>
            <?php endif; ?>
            <button class="file-action-btn" data-tooltip="Rename"
                onclick="showRenameForm('<?php echo htmlspecialchars(addslashes($file)); ?>', false)">
                <i class="fas fa-pencil-alt"></i>
            </button>
            <a href="?dir=<?php echo urlencode($_GET['dir'] ?? ''); ?>&delete=<?php echo urlencode($file); ?>"
                class="file-action-btn" data-tooltip="Delete"
                onclick="return confirm('Are you sure you want to delete this file?')">
                <i class="fas fa-trash"></i>
            </a>
        <?php endif; ?>
    </div>
</div>