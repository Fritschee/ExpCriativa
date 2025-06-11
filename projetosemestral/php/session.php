<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$session_timeout = 60; 
$login_page_url = '../pages/login.html'; 

$is_logged_in = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
$is_timed_out = false;

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $session_timeout)) {
    $is_timed_out = true;
}

if (!$is_logged_in || $is_timed_out) {
    session_unset();
    session_destroy();

    header("Location: $login_page_url");
    exit;
}

$_SESSION['LAST_ACTIVITY'] = time();

$session_regen_time = 60;
if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
} elseif (time() - $_SESSION['CREATED'] > $session_regen_time) {
    session_regenerate_id(true);
    $_SESSION['CREATED'] = time();
}