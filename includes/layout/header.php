<?php
/**
 * Header template for all pages
 * Contains the doctype, head section, and beginning of body with common layout elements
 */

// Default values if not passed
$pageTitle = $pageTitle ?? 'Zen File Manager';
$breadcrumbLinks = $breadcrumbLinks ?? [];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Source+Code+Pro:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/libs/font-awesome/css/all.min.css">
    <link rel="stylesheet" href="assets/css/improved-styles.css">
    <?php if (isset($additionalHeadContent)) echo $additionalHeadContent; ?>
</head>

<body>
    <div class="container-fluid">
        <div class="decorative-shape shape1"></div>
        <div class="decorative-shape shape2"></div>
        <div class="decorative-shape shape3"></div>

        <div class="container">
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
