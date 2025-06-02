<?php
// Functions for managing session data

/**
 * Initialize the session and set up buffer
 * 
 * @return array An array containing status message and type, if any
 */
function initializeSession()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Initialize the copy buffer if it doesn't exist
    if (!isset($_SESSION['copy_buffer'])) {
        $_SESSION['copy_buffer'] = [];
        $_SESSION['buffer_operation'] = null; // Can be 'copy' or 'cut'
    }

    // Check for messages from previous actions
    $statusMessage = '';
    $statusType = '';

    if (isset($_SESSION['status_message'])) {
        $statusMessage = $_SESSION['status_message'];
        $statusType = $_SESSION['status_type'];

        // Clear the messages
        unset($_SESSION['status_message']);
        unset($_SESSION['status_type']);
    }

    return [
        'statusMessage' => $statusMessage,
        'statusType' => $statusType
    ];
}

/**
 * Set a status message in the session
 * 
 * @param string $message The message to set
 * @param string $type The message type (success or error)
 */
function setStatusMessage($message, $type = 'success')
{
    $_SESSION['status_message'] = $message;
    $_SESSION['status_type'] = $type;
}

/**
 * Handle adding items to copy/cut buffer
 * 
 * @param array $selectedItems The items selected for copying/cutting
 * @param string $operation The operation (copy or cut)
 * @param string $currentDir The current directory
 * @param string $baseDir The base directory
 * @return void
 */
function handleCopyBuffer($selectedItems, $operation, $currentDir, $baseDir)
{
    $_SESSION['copy_buffer'] = [];
    // Set the operation type
    $_SESSION['buffer_operation'] = $operation;

    foreach ($selectedItems as $item) {
        $itemPath = $currentDir . '/' . basename($item);

        // Validate path is within allowed directory
        if (file_exists($itemPath) && strpos(realpath($itemPath), $baseDir) === 0) {
            $_SESSION['copy_buffer'][] = [
                'name' => basename($item),
                'path' => $itemPath,
                'is_dir' => is_dir($itemPath)
            ];
        }
    }

    $count = count($_SESSION['copy_buffer']);

    if ($count > 0) {
        $verb = $operation === 'copy' ? 'copied' : 'cut';
        $message = "$count item" . ($count > 1 ? 's' : '') . " $verb to buffer.";
        setStatusMessage($message, 'success');
    } else {
        $verb = $operation === 'copy' ? 'copying' : 'cutting';
        $message = "No valid items selected for $verb.";
        setStatusMessage($message, 'error');
    }
}

/**
 * Clear the copy buffer
 */
function clearCopyBuffer()
{
    $_SESSION['copy_buffer'] = [];
    $_SESSION['buffer_operation'] = null;

    setStatusMessage("Buffer cleared.", 'success');
}

/**
 * Get the current copy buffer
 * 
 * @return array The copy buffer and operation type
 */
function getStatusMessages()
{
    $statusMessage = '';
    $statusType = '';

    // Check for messages from previous actions
    if (isset($_SESSION['status_message'])) {
        $statusMessage = $_SESSION['status_message'];
        $statusType = $_SESSION['status_type'];

        // Clear the messages
        unset($_SESSION['status_message']);
        unset($_SESSION['status_type']);
    }

    return [
        'message' => $statusMessage,
        'type' => $statusType
    ];
}

/**
 * Clear the copy/cut buffer
 */
function clearBuffer()
{
    $_SESSION['copy_buffer'] = [];
    $_SESSION['buffer_operation'] = null;

    setStatusMessage("Buffer cleared.");
}
