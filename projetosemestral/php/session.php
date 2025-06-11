<?php
/**
 * session.php
 * This file manages user sessions, ensuring that only authenticated users can
 * access protected resources. It handles session startup, timeout, and security.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --- Configuration ---
$session_timeout = 60; // UPDATED: Session lifetime in seconds (60 seconds)
$session_regen_time = 60; // How often to regenerate session ID
$login_page_url = '../pages/login.html';

// --- Session Validation ---
$is_logged_in = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
$is_timed_out = false;

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $session_timeout)) {
    $is_timed_out = true;
}

if (!$is_logged_in || $is_timed_out) {
    session_unset();
    session_destroy();

    $is_ajax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

    if ($is_ajax) {
        http_response_code(401);
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => 'Sessão inválida ou expirada. Por favor, faça login novamente.',
            'action' => 'redirect',
            'url' => $login_page_url
        ]);
    } else {
        header("Location: $login_page_url");
    }
    exit;
}

// --- Session Maintenance ---
$_SESSION['LAST_ACTIVITY'] = time();

if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
} elseif (time() - $_SESSION['CREATED'] > $session_regen_time) {
    session_regenerate_id(true);
    $_SESSION['CREATED'] = time();
}