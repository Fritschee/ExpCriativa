<?php
session_start();

$timeout = 10; // ou 300 para 5 minutos

if (isset($_SESSION['LAST_ACTIVITY']) 
    && time() - $_SESSION['LAST_ACTIVITY'] > $timeout) {
    session_unset();
    session_destroy();
    header('Location: ../pages/login.html');
    exit;
}

// atualiza o timestamp da última atividade
$_SESSION['LAST_ACTIVITY'] = time();
