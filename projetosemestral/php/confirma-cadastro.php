<?php
include "conexao.php";

$mensagem = "";
$tipo = ""; // sucesso | erro | informacao
$redirecionamento = "register.html";

if (!isset($_GET['token'])) {
    $mensagem = "Token inválido ou não fornecido.";
    $tipo = "error";
} else {
    $token = mysqli_real_escape_string($con, $_GET['token']);

    $sql = "SELECT confirmado FROM usuario WHERE token = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 's', $token);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) === 1) {
        mysqli_stmt_bind_result($stmt, $confirmado);
        mysqli_stmt_fetch($stmt);

        if ($confirmado) {
            $mensagem = "Seu cadastro já havia sido confirmado anteriormente!";
            $tipo = "info";
            $redirecionamento = "login.html";
        } else {
            $sqlUpdate = "UPDATE usuario SET confirmado = true, token = NULL WHERE token = ?";
            $stmtUpdate = mysqli_prepare($con, $sqlUpdate);
            mysqli_stmt_bind_param($stmtUpdate, 's', $token);
            mysqli_stmt_execute($stmtUpdate);

            if (mysqli_stmt_affected_rows($stmtUpdate) > 0) {
                $mensagem = "Cadastro confirmado com sucesso!";
                $tipo = "success";
                $redirecionamento = "login.html";
                header("Refresh: 3; url=http://localhost/projetosemestral/pages/login.html");
            } else {
                $mensagem = "Erro ao confirmar cadastro. Tente novamente.";
                $tipo = "error";
                header("Refresh: 3; url=http://localhost/projetosemestral/pages/register.html");
            }

            mysqli_stmt_close($stmtUpdate);
        }
    } else {
        $mensagem = "Token inválido ou já utilizado.";
        $tipo = "error";
        header("Refresh: 3; url=http://localhost/projetosemestral/pages/register.html");
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Confirmação de Cadastro</title>
    <link rel="stylesheet" href="../css/confirma-cadastro.css">
</head>
<body>
    <div class="mensagem <?php echo $tipo; ?>">
        <strong><?php echo $mensagem; ?></strong>
        <small>Você será redirecionado em 3 segundos...</small>
    </div>
</body>
</html>
