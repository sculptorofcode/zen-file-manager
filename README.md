# 📁 Zen File Manager

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![PHP Version](https://img.shields.io/badge/PHP-7.4%2B-purple.svg)](https://php.net)
[![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg)](CONTRIBUTING.md)

<div align="center">
  <img src="https://via.placeholder.com/800x400?text=Zen+File+Manager" alt="Zen File Manager Banner" width="800">
</div>

## ✨ Overview

Zen File Manager is a clean, modern, and intuitive web-based file management solution that enables you to effortlessly browse, manipulate, and organize your files and directories through a beautiful, responsive interface. Built with PHP and modern web technologies, it provides a seamless file management experience directly from your browser.

## 🚀 Features

- **📂 File Operations**
  - Browse files and folders with an intuitive UI
  - Create, rename, copy, cut, and paste files/folders
  - Delete files/folders with confirmation
  - Real-time search and filtering capabilities

- **📤 Upload & Download**
  - Easy drag-and-drop file uploads
  - Multiple file upload support
  - Direct file downloads
  - ZIP file extraction

- **👁️ Preview & View**
  - View text files directly in the browser
  - Preview images and documents
  - Code syntax highlighting for common file types
  - Render HTML files in a preview pane

- **🔐 Security**
  - Path traversal prevention
  - Configurable base directory restriction
  - File operation validations
  - Session-based buffer management

- **💻 User Interface**
  - Clean, modern responsive design
  - Breadcrumb navigation for easy directory traversal
  - Intuitive status messages
  - Keyboard shortcuts support
  - Dark/Light theme support (coming soon)

## 📋 Requirements

- PHP 7.4 or higher
- Web server with PHP support (Apache, Nginx, etc.)
- Modern browser (Chrome, Firefox, Safari, Edge)

## 🔧 Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/yourusername/zen-file-manager.git
   ```

2. **Move to your web server directory**:
   ```bash
   mv zen-file-manager /path/to/your/webserver/
   ```

3. **Configure the base directory**:
   Edit `includes/config.php` to set your desired base directory.
   ```php
   define('BASE_DIR', '/absolute/path/to/directory');
   ```

4. **Set proper permissions**:
   ```bash
   chmod -R 755 /path/to/zen-file-manager
   ```

5. **Access through your web browser**:
   ```
   http://localhost/zen-file-manager/
   ```

## 🖥️ Usage

### Basic Navigation
- Click on folders to navigate into them
- Use the breadcrumb navigation to move back up
- Use the "Parent Directory" button to go one level up

### File Operations
1. **Create new file/folder**:
   - Click "New File" or "New Folder"
   - Enter name in the modal
   - Click "Create"

2. **Rename files/folders**:
   - Click the rename icon (✏️) next to the file/folder
   - Enter new name
   - Click "Rename"

3. **Copy, Cut & Paste**:
   - Click "File Operations" button
   - Select files/folders
   - Click "Copy" or "Cut"
   - Navigate to target directory
   - Click "Paste Here"

4. **Upload files**:
   - Click "Choose File" or drag files to the upload area
   - Click "Upload"

### Advanced Features
- **Extract ZIP files**: Click the extract icon next to any ZIP file
- **View Code Files**: Click the code icon to view file contents
- **Filter/Search**: Type in the search box to filter files in the current directory

## 🎨 Customization

### Styling
Edit the `assets/css/improved-styles.css` file to customize the look and feel.

### Configuration
Modify settings in `includes/config.php` to adjust behavior:
- Change the BASE_DIR setting to control access restrictions
- Add additional configuration parameters as needed

## 📚 Code Structure

```
├── assets/            # CSS, JS, and library files
│   ├── css/           # Stylesheets
│   ├── js/            # JavaScript files
│   └── libs/          # External libraries
├── includes/          # PHP functions and modules
│   ├── config.php     # Configuration settings
│   ├── file_operations.php  # File operation functions
│   ├── dir_operations.php   # Directory operation functions
│   └── ...            # Other function files
└── index.php          # Main application file
```

## 🔒 Security Considerations

- This application is intended for private networks or controlled environments
- Consider adding authentication for public installations
- Regularly check for updates to maintain security
- Limit access to sensitive directories through configuration

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 🙏 Acknowledgements

- [Font Awesome](https://fontawesome.com) for the beautiful icons
- [jQuery](https://jquery.com) for simplifying JavaScript operations

## 📬 Contact

Project Link: [https://github.com/yourusername/zen-file-manager](https://github.com/yourusername/zen-file-manager)

---

<div align="center">
  <sub>Built with ❤️ by contributors worldwide</sub>
</div>
