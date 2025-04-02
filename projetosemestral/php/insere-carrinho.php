<?php

$nome = $_POST['nome'];

include "conexao.php";

$sql = "INSERT INTO carrinho SELECT * FROM produto WHERE nome = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "s", $nome);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

// Fechar a conexão
mysqli_close($con);