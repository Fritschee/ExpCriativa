<?php
session_start();

require_once '../lib/GoogleAuthenticator/PHPGangsta/GoogleAuthenticator.php';
include "conexao.php";
header('Content-Type: application/json');

if (!isset($_SESSION['2fa_in_progress']) || $_SESSION['2fa_in_progress'] !== true || !isset($_SESSION['2fa_email'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Acesso negado. Por favor, realize o login primeiro.']);
    exit;
}

if (isset($_POST['code'])) {
    $email = $_SESSION['2fa_email'];
    $code = $_POST['code'];

    $stmt = mysqli_prepare($con, "SELECT nome, secret_2fa FROM usuario WHERE email = ?");
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $usuario = mysqli_fetch_assoc($result);

    if (!$usuario) {
        echo json_encode(['success' => false, 'message' => 'Usuário não encontrado.']);
        mysqli_close($con);
        exit;
    }
    
    $nome = $usuario['nome'];
    $secret = $usuario['secret_2fa'];
    mysqli_close($con);

    $g = new PHPGangsta_GoogleAuthenticator();
    $check_result = $g->verifyCode($secret, $code, 2);

    if ($check_result) {
        unset($_SESSION['2fa_in_progress'], $_SESSION['2fa_email']);
        session_regenerate_id(true);
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $email;
        $_SESSION['nome'] = $nome;
        $_SESSION['LAST_ACTIVITY'] = time();
        $_SESSION['CREATED'] = time();
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Código 2FA inválido.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Código 2FA não foi fornecido.']);
}