<?php
include "conexao.php";

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Verifica se o usuário existe e está confirmado
    $sql = "SELECT email, senha, confirmado FROM usuario WHERE email = ? AND senha = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'ss', $email, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $usuario = mysqli_fetch_assoc($result);

        if ($usuario['confirmado']) {
            // Usuário existe e já confirmou o cadastro
            echo json_encode(['success' => true]);
        } else {
            // Usuário existe, mas não confirmou
            echo json_encode(['success' => false, 'message' => 'Sua conta ainda não foi confirmada. Verifique seu e-mail.']);
        }

    } else {
        // Usuário não encontrado ou credenciais incorretas
        echo json_encode(['success' => false, 'message' => 'Credenciais inválidas.']);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);
} else {
    echo json_encode(['success' => false, 'message' => 'Dados incompletos.']);
}
