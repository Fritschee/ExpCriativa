<?php
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
        } elseif ($usuario['senha'] !== $password) {
            echo json_encode(['success' => false, 'message' => 'Credenciais inválidas.']);
        } elseif (!empty($usuario['secret_2fa'])) {
            // Login com 2FA ativado
            echo json_encode([
                'success' => true,
                'require_2fa' => true,
                'email' => $usuario['email'],
                'nome' => $usuario['nome']
            ]);
        } else {
            // Login direto (sem 2FA)
            echo json_encode([
                'success' => true,
                'email' => $usuario['email'],
                'nome' => $usuario['nome']
            ]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Credenciais inválidas.']);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);
} else {
    echo json_encode(['success' => false, 'message' => 'Dados incompletos.']);
}
