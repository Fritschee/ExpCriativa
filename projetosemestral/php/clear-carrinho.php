<?php
header('Content-Type: application/json');
include "conexao.php";

$sql = "DELETE FROM carrinho";

if (mysqli_query($con, $sql)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao limpar carrinho.']);
}

mysqli_close($con);
