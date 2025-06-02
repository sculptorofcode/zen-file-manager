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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support - Zen File Manager</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Source+Code+Pro:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/libs/font-awesome/css/all.min.css">
    <link rel="stylesheet" href="assets/css/improved-styles.css">
</head>

<body>
    <div class="container-fluid">
        <div class="decorative-shape shape1"></div>
        <div class="decorative-shape shape2"></div>
        <div class="decorative-shape shape3"></div>

        <div class="container">
            <div class="header">
                <h1 class="title">📁 Zen File Manager</h1>
                <div class="breadcrumb">
                    <a href="index.php"><i class="fas fa-home"></i> Home</a>
                    <span>/</span>
                    <a href="support.php">Support</a>
                </div>
            </div>

            <div class="page-content">
                <div class="content-section">
                    <h2><i class="fas fa-heart"></i> Support &amp; Community</h2>
                    
                    <div class="content-card">
                        <div class="card-header">
                            <h3>Getting Support</h3>
                        </div>
                        <div class="card-body">
                            <p>We're committed to helping you have the best possible experience with Zen File Manager. Here are the ways you can get support:</p>
                            
                            <div class="support-options">
                                <div class="support-option">
                                    <div class="support-icon">
                                        <i class="fab fa-github"></i>
                                    </div>
                                    <div class="support-details">
                                        <h4>GitHub Issues</h4>
                                        <p>Report bugs, request features, or ask technical questions through our GitHub repository.</p>
                                        <a href="https://github.com/yourusername/zen-file-manager/issues" target="_blank" class="btn btn-secondary">
                                            Open an Issue
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="support-option">
                                    <div class="support-icon">
                                        <i class="fas fa-book"></i>
                                    </div>
                                    <div class="support-details">
                                        <h4>Documentation</h4>
                                        <p>Our comprehensive documentation includes installation guides, usage instructions, and FAQs.</p>
                                        <a href="help.php" class="btn btn-secondary">
                                            View Documentation
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="support-option">
                                    <div class="support-icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div class="support-details">
                                        <h4>Email Support</h4>
                                        <p>For private inquiries or specialized support needs, reach out via email.</p>
                                        <a href="mailto:support@zenfilemanager.example.com" class="btn btn-secondary">
                                            Email Support
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="content-card">
                        <div class="card-header">
                            <h3>Frequently Asked Questions</h3>
                        </div>
                        <div class="card-body">
                            <div class="faq-container">
                                <div class="faq-item">
                                    <div class="faq-question">
                                        <i class="fas fa-question-circle"></i>
                                        <h4>Is Zen File Manager free to use?</h4>
                                    </div>
                                    <div class="faq-answer">
                                        <p>Yes, Zen File Manager is completely free and open-source under the MIT License. You can use, modify, and distribute it freely for personal or commercial projects.</p>
                                    </div>
                                </div>
                                
                                <div class="faq-item">
                                    <div class="faq-question">
                                        <i class="fas fa-question-circle"></i>
                                        <h4>What are the system requirements?</h4>
                                    </div>
                                    <div class="faq-answer">
                                        <p>Zen File Manager requires:</p>
                                        <ul>
                                            <li>PHP 7.4 or higher</li>
                                            <li>A web server with PHP support (Apache, Nginx, etc.)</li>
                                            <li>Modern browser (Chrome, Firefox, Safari, Edge)</li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <div class="faq-item">
                                    <div class="faq-question">
                                        <i class="fas fa-question-circle"></i>
                                        <h4>Is authentication available?</h4>
                                    </div>
                                    <div class="faq-answer">
                                        <p>The current version does not include built-in authentication. For production use, we recommend placing the file manager behind a secured area of your website or using web server authentication mechanisms.</p>
                                    </div>
                                </div>
                                
                                <div class="faq-item">
                                    <div class="faq-question">
                                        <i class="fas fa-question-circle"></i>
                                        <h4>How can I contribute to the project?</h4>
                                    </div>
                                    <div class="faq-answer">
                                        <p>We welcome contributions! You can contribute by:</p>
                                        <ul>
                                            <li>Submitting bug reports and feature requests</li>
                                            <li>Creating pull requests for code improvements</li>
                                            <li>Improving documentation</li>
                                            <li>Sharing the project with others</li>
                                        </ul>
                                        <p>Please see our <a class="link" href="https://github.com/yourusername/zen-file-manager/blob/main/CONTRIBUTING.md" target="_blank">contribution guidelines</a> for more details.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="content-card">
                        <div class="card-header">
                            <h3>Community & Contributing</h3>
                        </div>
                        <div class="card-body">
                            <p>Zen File Manager is made better through community involvement. Join our community and help improve the project!</p>
                            
                            <div class="contribution-ways">
                                <div class="contribution-way">
                                    <div class="contribution-icon">
                                        <i class="fas fa-code"></i>
                                    </div>
                                    <div class="contribution-details">
                                        <h4>Code Contributions</h4>
                                        <p>Help us improve functionality, fix bugs, or add new features by submitting pull requests.</p>
                                    </div>
                                </div>
                                
                                <div class="contribution-way">
                                    <div class="contribution-icon">
                                        <i class="fas fa-bug"></i>
                                    </div>
                                    <div class="contribution-details">
                                        <h4>Bug Reports</h4>
                                        <p>Found a bug? Report it on GitHub with steps to reproduce, and help us make the file manager more stable.</p>
                                    </div>
                                </div>
                                
                                <div class="contribution-way">
                                    <div class="contribution-icon">
                                        <i class="fas fa-language"></i>
                                    </div>
                                    <div class="contribution-details">
                                        <h4>Translations</h4>
                                        <p>Help translate Zen File Manager into different languages to make it accessible to more users worldwide.</p>
                                    </div>
                                </div>
                                
                                <div class="contribution-way">
                                    <div class="contribution-icon">
                                        <i class="fas fa-lightbulb"></i>
                                    </div>
                                    <div class="contribution-details">
                                        <h4>Feature Requests</h4>
                                        <p>Have ideas for improving the file manager? Share your feature suggestions on GitHub.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="github-cta">
                                <a href="https://github.com/yourusername/zen-file-manager" target="_blank" class="btn btn-primary">
                                    <i class="fab fa-github"></i> Visit GitHub Repository
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="content-card">
                        <div class="card-header">
                            <h3>Sponsorship & Donations</h3>
                        </div>
                        <div class="card-body">
                            <p>Zen File Manager is maintained as a free and open-source project. If you find it useful, consider supporting its development!</p>
                            
                            <div class="sponsor-options">
                                <div class="sponsor-option">
                                    <div class="sponsor-icon">
                                        <i class="fab fa-github"></i>
                                    </div>
                                    <div class="sponsor-details">
                                        <h4>GitHub Sponsors</h4>
                                        <p>Support the project through GitHub's sponsorship program.</p>
                                        <a href="https://github.com/sponsors/sculptorofcode" target="_blank" class="btn btn-accent">
                                            Sponsor on GitHub
                                        </a>
                                    </div>
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
