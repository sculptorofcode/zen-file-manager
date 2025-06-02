<?php
/**
 * Header layout template
 * 
 * Displays the header section including logo, title and breadcrumb navigation.
 * 
 * Usage: include 'includes/layout/header.php';
 * 
 * Requires variables:
 * $pageTitle - Title of the current page
 * $breadcrumbs - Array of breadcrumb links (optional, for file browsing pages)
 */

// Set default page title if not provided
if (!isset($pageTitle)) {
    $pageTitle = 'File Manager';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="icon" href="assets/img/logo.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Source+Code+Pro:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/libs/font-awesome/css/all.min.css">
    <link rel="stylesheet" href="assets/libs/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/improved-styles.css">
    <?php if (isset($additionalHeadContent)) echo $additionalHeadContent; ?>

    <!-- SEO Meta Tags -->
    <meta name="description" content="Zen File Manager - A powerful and user-friendly tool for managing your files and directories">
    <meta name="keywords" content="file manager, file browser, file upload, file sharing, document management">
    <meta name="author" content="Zen File Manager">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="<?php echo htmlspecialchars($pageTitle); ?>">
    <meta property="og:description" content="Zen File Manager - Easily manage, upload, and organize your files">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
    <meta property="og:image" content="assets/img/zen-file-manager-banner.png">
    <meta name="twitter:card" content="summary_large_image">
    <!-- / SEO Meta Tags -->

</head>

<body>
    <div class="container-fluid">
        <div class="decorative-shape shape1"></div>
        <div class="decorative-shape shape2"></div>
        <div class="decorative-shape shape3"></div>

        <div class="container mt-5">
            <div class="header">
                <div class="logo-container">
                    <img src="assets/img/logo.png" alt="Zen File Manager" class="logo">
                    <h1 class="title">Zen File Manager</h1>
                </div>

                <div class="breadcrumb">
                    <?php if (!empty($breadcrumbHtml)): ?>
                        <?php echo $breadcrumbHtml; ?>
                    <?php elseif (!empty($breadcrumbLinks)): ?>
                        <a href="index.php"><i class="fas fa-home"></i> Home</a>
                        <?php foreach ($breadcrumbLinks as $link => $text): ?>
                            <span>/</span>
                            <a href="<?php echo htmlspecialchars($link); ?>"><?php echo htmlspecialchars($text); ?></a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>