<?php

include "conexao.php";

if (!isset($_GET['token'])) {
    echo "<h3>Token inválido ou não fornecido.</h3>";
    header("Refresh: 3; url=http://localhost/ExpCriativa/projetosemestral/pages/register.html");
    exit;
}

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
        echo "<h3>Seu cadastro já foi confirmado anteriormente!</h3>";
        header("Refresh: 3; url=http://localhost/ExpCriativa/projetosemestral/pages/login.html");
    } else {
        $sqlUpdate = "UPDATE usuario SET confirmado = true, token = NULL WHERE token = ?";
        $stmtUpdate = mysqli_prepare($con, $sqlUpdate);
        mysqli_stmt_bind_param($stmtUpdate, 's', $token);
        mysqli_stmt_execute($stmtUpdate);

        if (mysqli_stmt_affected_rows($stmtUpdate) > 0) {
            echo "<h3>Cadastro confirmado com sucesso!</h3>";
            header("Refresh: 3; url=http://localhost/ExpCriativa/projetosemestral/pages/login.html");
        } else {
            echo "<h3>Erro ao confirmar cadastro. Tente novamente.</h3>";
            header("Refresh: 3; url=http://localhost/ExpCriativa/projetosemestral/pages/register.html");
        }

        mysqli_stmt_close($stmtUpdate);
    }
} else {
    echo "<h3>Token inválido ou já utilizado.</h3>";
    header("Refresh: 3; url=http://localhost/ExpCriativa/projetosemestral/pages/register.html");
}

mysqli_stmt_close($stmt);
mysqli_close($con);
