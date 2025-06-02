// File Manager JavaScript

// Initialize the page - mark cut buffer items if any
document.addEventListener('DOMContentLoaded', function() {
    highlightCutItems();
    setupCardAnimations();
    setupDynamicUI();
    // setupFileUpload();
});

function highlightCutItems() {
    // Check for cut buffers in PHP-generated JavaScript variables
    if (typeof cutBufferItems !== 'undefined' && cutBufferMode === 'cut') {
        // Remove any existing highlights
        document.querySelectorAll('.file-card.in-cut-buffer').forEach(card => {
            card.classList.remove('in-cut-buffer');
        });
        
        // Add highlights to files in cut buffer
        cutBufferItems.forEach(itemName => {
            document.querySelectorAll('.file-card').forEach(card => {
                const fileName = card.querySelector('.file-name').textContent;
                if (fileName === itemName) {
                    card.classList.add('in-cut-buffer');
                }
            });
        });
    }
}

// Setup staggered animations for file cards
function setupCardAnimations() {
    const cards = document.querySelectorAll('.file-card');
    
    cards.forEach((card, index) => {
        // Set staggered animation delay
        card.style.animationDelay = `${index * 0.05}s`;
        
        // Add hover animation classes based on file type
        if (card.classList.contains('file-type-folder')) {
            card.setAttribute('data-animation', 'bounce');
        } else if (card.classList.contains('file-type-image')) {
            card.setAttribute('data-animation', 'pulse');
        } else {
            card.setAttribute('data-animation', 'float');
        }
    });
}

// Setup dynamic UI elements and interactions
function setupDynamicUI() {
    // Add tooltips to action buttons
    document.querySelectorAll('.file-action-btn').forEach(btn => {
        const tooltip = btn.getAttribute('data-tooltip');
        if (tooltip) {
            btn.addEventListener('mouseenter', () => {
                btn.style.transform = 'scale(1.1)';
            });
            btn.addEventListener('mouseleave', () => {
                btn.style.transform = '';
            });
        }
    });

    // Add ripple effect to buttons
    document.querySelectorAll('.btn').forEach(btn => {
        btn.addEventListener('click', createRipple);
    });
    
    // Enhance search form
    const searchInput = document.getElementById('search-input');
    if (searchInput) {
        searchInput.addEventListener('focus', () => {
            document.querySelector('.search-section').classList.add('searching');
        });
        searchInput.addEventListener('blur', () => {
            document.querySelector('.search-section').classList.remove('searching');
        });
    }
}

// Create ripple effect on button click
function createRipple(event) {
    const button = event.currentTarget;
    
    const circle = document.createElement('span');
    const diameter = Math.max(button.clientWidth, button.clientHeight);
    const radius = diameter / 2;
    
    circle.style.width = circle.style.height = `${diameter}px`;
    circle.style.left = `${event.clientX - button.getBoundingClientRect().left - radius}px`;
    circle.style.top = `${event.clientY - button.getBoundingClientRect().top - radius}px`;
    circle.classList.add('ripple');
    
    const ripple = button.querySelector('.ripple');
    
    if (ripple) {
        ripple.remove();
    }
    
    button.appendChild(circle);
}

function filterFiles() {
    const searchTerm = document.getElementById('search-input').value.toLowerCase();
    const fileCards = document.querySelectorAll('.file-card');

    fileCards.forEach(card => {
        const fileName = card.querySelector('.file-name').textContent.toLowerCase();
        if (fileName.includes(searchTerm)) {
            card.style.display = 'block'; // Show matching file
        } else {
            card.style.display = 'none'; // Hide non-matching file
        }
    });
}

// Rename functionality
function showRenameForm(fileName, isDirectory) {
    const modal = document.getElementById('renameModal');
    const form = document.getElementById('renameForm');
    const input = document.getElementById('newName');
    const itemType = document.getElementById('renameItemType');
    
    // Set the item type (File or Folder)
    itemType.textContent = isDirectory ? 'Folder' : 'File';
    
    // Set the current file name as the default value
    input.value = fileName;
    
    // Set the form action
    const currentDir = new URLSearchParams(window.location.search).get('dir') || '';
    form.action = `?dir=${encodeURIComponent(currentDir)}&rename=${encodeURIComponent(fileName)}`;
    
    // Show the modal
    modal.style.display = 'block';
    
    // Focus on the input
    input.focus();
    
    // Select the filename part without extension if it's a file
    if (!isDirectory) {
        const lastDotPosition = fileName.lastIndexOf('.');
        if (lastDotPosition > 0) {
            input.setSelectionRange(0, lastDotPosition);
        } else {
            input.select();
        }
    } else {
        input.select();
    }
}

function closeRenameModal() {
    const modal = document.getElementById('renameModal');
    modal.style.display = 'none';
}

// Create file/folder functionality
function showCreateForm(type) {
    const modal = document.getElementById('createModal');
    const form = document.getElementById('createForm');
    const input = document.getElementById('createName');
    const itemType = document.getElementById('createItemType');
    const typeInput = document.getElementById('createType');
    
    // Set the item type (File or Folder)
    itemType.textContent = type === 'folder' ? 'Folder' : 'File';
    typeInput.value = type;
    
    // Clear the input
    input.value = '';
    
    // Set the form action - just use the current URL
    const currentDir = new URLSearchParams(window.location.search).get('dir') || '';
    form.action = `?dir=${encodeURIComponent(currentDir)}`;
    
    // Show the modal
    modal.style.display = 'block';
    
    // Focus on the input
    input.focus();
    
    // Add placeholder suggestion based on type
    if (type === 'file') {
        input.placeholder = 'example.txt';
    } else {
        input.placeholder = 'new_folder';
    }
}

function closeCreateModal() {
    const modal = document.getElementById('createModal');
    modal.style.display = 'none';
}

// Handle modal events
window.onclick = function(event) {
    const renameModal = document.getElementById('renameModal');
    const createModal = document.getElementById('createModal');
    
    if (event.target === renameModal) {
        closeRenameModal();
    }
    
    if (event.target === createModal) {
        closeCreateModal();
    }
}

// Close modals with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeRenameModal();
        closeCreateModal();
    }
});

// Selection mode functionality
let isSelectionMode = false;
const selectedItems = new Set();

function toggleSelectionMode() {
    isSelectionMode = !isSelectionMode;
    const bulkPanel = document.getElementById('bulk-op-panel');
    const selectionBtn = document.getElementById('selection-mode-btn');
    
    if (isSelectionMode) {
        // Create a new bulk operation panel if it doesn't exist
        if (!bulkPanel) {
            createBulkOperationPanel();
        } else {
            // Show the existing panel
            bulkPanel.style.display = 'block';
        }
        selectionBtn.classList.add('active');
        
        // Make file cards clickable for selection
        document.querySelectorAll('.file-card').forEach(card => {
            // Skip the parent directory card
            if (card.classList.contains('special-card')) return;
            
            card.addEventListener('click', toggleItemSelection);
            card.style.cursor = 'pointer';
        });
        
        // Prevent default behavior of links when in selection mode
        document.querySelectorAll('.file-action-btn').forEach(link => {
            link.addEventListener('click', preventDefaultWhenSelecting);
        });
        
    } else {
        bulkPanel.style.display = 'none';
        selectionBtn.classList.remove('active');
        clearSelection();
        
        // Remove selection event listeners
        document.querySelectorAll('.file-card').forEach(card => {
            card.removeEventListener('click', toggleItemSelection);
            card.style.cursor = '';
        });
        
        // Restore default behavior of links
        document.querySelectorAll('.file-action-btn').forEach(link => {
            link.removeEventListener('click', preventDefaultWhenSelecting);
        });
    }
}

function preventDefaultWhenSelecting(e) {
    if (isSelectionMode) {
        e.preventDefault();
        e.stopPropagation();
    }
}

function toggleItemSelection(e) {
    if (!isSelectionMode) return;
    
    // Don't toggle if clicking on an action button
    if (e.target.closest('.file-action-btn')) return;
    
    const card = e.currentTarget;
    const fileName = card.querySelector('.file-name').textContent;
    
    if (selectedItems.has(fileName)) {
        selectedItems.delete(fileName);
        card.classList.remove('selected');
    } else {
        selectedItems.add(fileName);
        card.classList.add('selected');
    }
    
    updateSelectedCount();
    updateSelectedItemsInput();
}

function updateSelectedCount() {
    const count = selectedItems.size;
    document.getElementById('selected-count').textContent = 
        count + ' item' + (count !== 1 ? 's' : '') + ' selected';
}

function updateSelectedItemsInput() {
    // Clear existing inputs
    const container = document.getElementById('selected-items-container');
    container.innerHTML = '';
    
    // Add hidden input for each selected item
    selectedItems.forEach(item => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'selected_items[]';
        input.value = item;
        container.appendChild(input);
    });
}

function clearSelection() {
    selectedItems.clear();
    document.querySelectorAll('.file-card.selected').forEach(card => {
        card.classList.remove('selected');
    });
    updateSelectedCount();
}

function cancelSelection() {
    toggleSelectionMode();
    clearSelection();
}

function confirmPaste() {
    const form = document.getElementById('bulk-form');
    const pasteInput = document.getElementById('paste_items_input');
    
    if (typeof cutBufferMode !== 'undefined' && cutBufferMode === 'cut') {
        const itemCount = cutBufferItemCount || 0;
        const message = itemCount === 1 ? 
            'Are you sure you want to move the selected item to this location?' : 
            `Are you sure you want to move ${itemCount} items to this location?`;
            
        if (confirm(message)) {
            pasteInput.disabled = false;
            form.submit();
        }
    } else {
        pasteInput.disabled = false;
        form.submit();
    }
}

// Create bulk operation panel dynamically
function createBulkOperationPanel() {
    const searchSection = document.querySelector('.search-section');
    if (!searchSection) return;
    
    const parent = searchSection.parentNode;
    
    // Create bulk operation panel
    const bulkPanel = document.createElement('div');
    bulkPanel.id = 'bulk-op-panel';
    bulkPanel.className = 'bulk-op-panel';
    
    // Add buffer mode class if buffer operation exists
    if (typeof cutBufferMode !== 'undefined') {
        bulkPanel.classList.add(cutBufferMode + '-mode');
    }
    
    // Create form and contents
    const form = document.createElement('form');
    form.method = 'post';
    form.id = 'bulk-form';
    
    // Add bulk info section
    const bulkInfo = document.createElement('div');
    bulkInfo.className = 'bulk-info';
    
    const selectedCount = document.createElement('span');
    selectedCount.id = 'selected-count';
    selectedCount.textContent = '0 items selected';
    bulkInfo.appendChild(selectedCount);
    
    // Add buffer info if buffer has items
    if (typeof cutBufferItems !== 'undefined' && cutBufferItems.length > 0) {
        const bufferInfo = document.createElement('span');
        bufferInfo.className = 'buffer-info';
        bufferInfo.textContent = '(' + cutBufferItems.length + ' items in buffer - ' + 
            (cutBufferMode === 'cut' ? 'Cut' : 'Copy') + ' mode)';
        bulkInfo.appendChild(bufferInfo);
    }
    
    form.appendChild(bulkInfo);
    
    // Add bulk buttons
    const bulkButtons = document.createElement('div');
    bulkButtons.className = 'bulk-buttons';
    
    // Copy button
    const copyButton = document.createElement('button');
    copyButton.type = 'submit';
    copyButton.name = 'copy_items';
    copyButton.className = 'btn btn-light bulk-btn copy-btn';
    copyButton.innerHTML = '<i class="fas fa-copy"></i> Copy';
    
    // Cut button
    const cutButton = document.createElement('button');
    cutButton.type = 'submit';
    cutButton.name = 'cut_items';
    cutButton.className = 'btn btn-light bulk-btn cut-btn';
    cutButton.innerHTML = '<i class="fas fa-cut"></i> Cut';
    
    bulkButtons.appendChild(copyButton);
    bulkButtons.appendChild(cutButton);
    
    // Add paste and clear buttons if buffer has items
    if (typeof cutBufferItems !== 'undefined' && cutBufferItems.length > 0) {
        // Paste button
        const pasteButton = document.createElement('button');
        pasteButton.type = 'button';
        pasteButton.className = 'btn btn-primary bulk-btn paste-btn';
        pasteButton.innerHTML = '<i class="fas fa-paste"></i> Paste Here';
        pasteButton.onclick = confirmPaste;
        
        // Clear buffer button
        const clearButton = document.createElement('button');
        clearButton.type = 'submit';
        clearButton.name = 'clear_buffer';
        clearButton.className = 'btn btn-danger bulk-btn clear-btn';
        clearButton.innerHTML = '<i class="fas fa-times"></i> Clear Buffer';
        
        bulkButtons.appendChild(pasteButton);
        bulkButtons.appendChild(clearButton);
        
        // Add hidden input for paste operation
        const pasteInput = document.createElement('input');
        pasteInput.type = 'hidden';
        pasteInput.name = 'paste_items';
        pasteInput.id = 'paste_items_input';
        pasteInput.disabled = true;
        form.appendChild(pasteInput);
    }
    
    // Cancel button
    const cancelButton = document.createElement('button');
    cancelButton.type = 'button';
    cancelButton.className = 'btn btn-light bulk-btn cancel-btn';
    cancelButton.innerHTML = '<i class="fas fa-times-circle"></i> Cancel';
    cancelButton.onclick = cancelSelection;
    bulkButtons.appendChild(cancelButton);
    
    form.appendChild(bulkButtons);
    
    // Add container for selected items
    const selectedItemsContainer = document.createElement('div');
    selectedItemsContainer.id = 'selected-items-container';
    form.appendChild(selectedItemsContainer);
    
    bulkPanel.appendChild(form);
    
    // Insert the bulk panel before the search section
    parent.insertBefore(bulkPanel, searchSection);
}