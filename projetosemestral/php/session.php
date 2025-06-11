<?php
/**
 * session.php
 * This file manages user sessions, ensuring that only authenticated users can
 * access protected resources. It handles session startup, timeout, and security.
 */

// Start session if not already started. This must be called before any output.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --- Configuration ---
$session_timeout = 60; // Session lifetime in seconds (60 seconds)
$login_page_url = '../pages/login.html'; // Redirect destination for unauthenticated users

// --- Session Validation ---
$is_logged_in = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
$is_timed_out = false;

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $session_timeout)) {
    $is_timed_out = true;
}

if (!$is_logged_in || $is_timed_out) {
    session_unset();
    session_destroy();

    // For direct page access (like index.php), perform a standard redirect
    header("Location: $login_page_url");
    exit;
}

// --- Session Maintenance ---
$_SESSION['LAST_ACTIVITY'] = time();

// Regenerate session ID periodically to protect against session fixation attacks
$session_regen_time = 60;
if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
} elseif (time() - $_SESSION['CREATED'] > $session_regen_time) {
    session_regenerate_id(true); // Create new session ID and delete the old one
    $_SESSION['CREATED'] = time();
}