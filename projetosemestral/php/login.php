<?php
session_start();
error_reporting(0);
ob_clean();
header('Content-Type: application/json');

include "conexao.php";

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    $sql = "SELECT nome, email, senha, confirmado, secret_2fa FROM usuario WHERE email = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($usuario = mysqli_fetch_assoc($result)) {
        if (!$usuario['confirmado']) {
            echo json_encode(['success' => false, 'message' => 'Conta não confirmada.']);
            exit;
        }
        if ($usuario['senha'] !== $password) {
            echo json_encode(['success' => false, 'message' => 'Credenciais inválidas.']);
            exit;
        }

        if (!empty($usuario['secret_2fa'])) {
            $_SESSION['2fa_in_progress'] = true;
            $_SESSION['2fa_email'] = $usuario['email'];
            echo json_encode(['success' => true, 'require_2fa' => true, 'email' => $usuario['email'], 'nome' => $usuario['nome']]);
        } else {
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $usuario['email'];
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['LAST_ACTIVITY'] = time();
            $_SESSION['CREATED'] = time();
            unset($_SESSION['2fa_in_progress'], $_SESSION['2fa_email']);
            echo json_encode(['success' => true, 'require_2fa' => false, 'email' => $usuario['email'], 'nome' => $usuario['nome']]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Credenciais inválidas.']);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);
} else {
    echo json_encode(['success' => false, 'message' => 'Dados de login incompletos.']);
}