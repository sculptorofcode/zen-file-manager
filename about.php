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

// Set the page title
$pageTitle = 'About - Zen File Manager';
$breadcrumbLinks = ['about.php' => 'About'];

// Include header
require_once 'includes/layout/header.php';
?>

<div class="page-content">
    <div class="content-section">
        <h2><i class="fas fa-info-circle"></i> About Zen File Manager</h2>

        <div class="content-card">
            <div class="card-header">
                <h3>Overview</h3>
            </div>
            <div class="card-body">
                <p>Zen File Manager is a modern, clean, and intuitive web-based file management solution designed to provide a seamless experience for browsing, organizing, and manipulating your files and directories directly from your browser.</p>

                <div class="feature-grid">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-folder-open"></i>
                        </div>
                        <h4>File Operations</h4>
                        <p>Browse, create, copy, cut, paste, and delete files and folders with an intuitive interface.</p>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-upload"></i>
                        </div>
                        <h4>Upload & Download</h4>
                        <p>Easy file uploading and downloading with ZIP extraction capabilities.</p>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <h4>Preview & View</h4>
                        <p>View text files, preview images, and render HTML directly in your browser.</p>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        <h4>Security</h4>
                        <p>Path traversal prevention and configurable directory restrictions to keep your files safe.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="content-card">
                    <div class="card-header">
                        <h3>Vision & Goals</h3>
                    </div>
                    <div class="card-body">
                        <p>Our mission is to create a file management tool that combines functionality with aesthetics, providing both power and simplicity. We believe file management should be zen-like: effortless, intuitive, and pleasant.</p>

                        <div class="goals">
                            <div class="goal">
                                <i class="fas fa-check-circle"></i>
                                <p>Create a file manager that's beautiful as well as functional</p>
                            </div>
                            <div class="goal">
                                <i class="fas fa-check-circle"></i>
                                <p>Provide an intuitive interface that requires minimal learning</p>
                            </div>
                            <div class="goal">
                                <i class="fas fa-check-circle"></i>
                                <p>Ensure security and reliability in all file operations</p>
                            </div>
                            <div class="goal">
                                <i class="fas fa-check-circle"></i>
                                <p>Maintain high performance even with large directories</p>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="content-card">
                    <div class="card-header">
                        <h3>Developer Profile</h3>
                    </div>
                    <div class="card-body">
                        <div class="profile-container">
                            <!-- Profile Header Row -->
                            <div class="profile-row profile-header-row">
                                <div class="profile-avatar overflow-hidden">
                                    <img src="https://wbeokcjfdnizxajsdghm.supabase.co/storage/v1/object/public/profiles/profile-1747994311801.jpg" alt="" class="img-fluid">
                                </div>
                                <div class="profile-info">
                                    <h4>Saikat Roy</h4>
                                    <span class="profile-title">Cybersecurity Enthusiast & Web Developer</span>
                                </div>
                            </div>

                            <hr class="profile-divider">

                            <!-- Profile Content Row -->
                            <div class="profile-column profile-content-row">
                                <!-- Bio Column -->
                                <div class="profile-column">
                                    <h5 class="profile-section-title">Bio</h5>
                                    <div class="profile-bio">
                                        <p>Living in the moment & spreading joy ❤️✨ Full-stack web developer with a passion for cybersecurity and creating innovative, user-friendly applications.</p>
                                    </div>
                                </div>

                                <!-- Skills Column -->
                                <div class="profile-column">
                                    <h5 class="profile-section-title">Skills</h5>
                                    <div class="profile-skills">
                                        <div class="skill-tag">PHP</div>
                                        <div class="skill-tag">JavaScript</div>
                                        <div class="skill-tag">MySQL</div>
                                        <div class="skill-tag">HTML/CSS</div>
                                        <div class="skill-tag">Cybersecurity</div>
                                        <div class="skill-tag">Web Development</div>
                                    </div>
                                </div>
                            </div>

                            <hr class="profile-divider">

                            <!-- Social Links Row -->
                            <div class="profile-row profile-links-row">
                                <h5 class="profile-section-title">Connect With Me</h5>
                                <div class="profile-links">
                                    <a href="https://www.linkedin.com/in/sculptorofcode/" class="profile-link" target="_blank">
                                        <i class="fab fa-linkedin"></i> LinkedIn
                                    </a>
                                    <a href="https://github.com/sculptorofcode" class="profile-link" target="_blank">
                                        <i class="fab fa-github"></i> GitHub
                                    </a>
                                    <a href="https://instagram.com/sculptor_of_code" class="profile-link" target="_blank">
                                        <i class="fab fa-instagram"></i> Instagram
                                    </a>
                                    <a href="https://www.facebook.com/sculptor.of.code/" class="profile-link" target="_blank">
                                        <i class="fab fa-facebook"></i> Facebook
                                    </a>
                                    <a href="https://x.com/sr724528" class="profile-link" target="_blank">
                                        <i class="fab fa-twitter"></i> X
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="content-card">
                    <div class="card-header">
                        <h3>Technical Details</h3>
                    </div>
                    <div class="card-body">
                        <p>Zen File Manager is built with modern web technologies:</p>

                        <div class="tech-stack">
                            <div class="tech-item">
                                <div class="tech-logo">
                                    <i class="fab fa-php"></i>
                                </div>
                                <div class="tech-details">
                                    <h4>PHP</h4>
                                    <p>Powers the backend file operations and directory management</p>
                                </div>
                            </div>

                            <div class="tech-item">
                                <div class="tech-logo">
                                    <i class="fab fa-js-square"></i>
                                </div>
                                <div class="tech-details">
                                    <h4>JavaScript</h4>
                                    <p>Provides interactive features and smooth user experience</p>
                                </div>
                            </div>

                            <div class="tech-item">
                                <div class="tech-logo">
                                    <i class="fab fa-css3-alt"></i>
                                </div>
                                <div class="tech-details">
                                    <h4>CSS3</h4>
                                    <p>Creates the beautiful and responsive design</p>
                                </div>
                            </div>

                            <div class="tech-item">
                                <div class="tech-logo">
                                    <i class="fab fa-html5"></i>
                                </div>
                                <div class="tech-details">
                                    <h4>HTML5</h4>
                                    <p>Structures the content and interface elements</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="content-card">
                    <div class="card-header">
                        <h3>Version Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="version-info">
                            <div class="version-item">
                                <span class="label">Current Version:</span>
                                <span class="value"><?= VERSION ?></span>
                            </div>
                            <div class="version-item">
                                <span class="label">Release Date:</span>
                                <span class="value"><?= RELEASE ?></span>
                            </div>
                            <div class="version-item">
                                <span class="label">License:</span>
                                <span class="value">MIT License</span>
                            </div>
                        </div>

                        <div class="version-actions">
                            <a href="https://github.com/sculptorofcode/zen-file-manager" class="btn btn-primary" target="_blank">
                                <i class="fab fa-github"></i> View on GitHub
                            </a>
                            <a href="https://github.com/sculptorofcode/zen-file-manager/issues" class="btn btn-secondary" target="_blank">
                                <i class="fas fa-bug"></i> Report Issues
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

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/main.js"></script>

<?php include 'includes/layout/footer.php'; ?>
</body>

</html>