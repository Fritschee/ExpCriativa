<?php
require_once __DIR__ . '/session.php';
header('Content-Type: application/json');
include "conexao.php";

$sql = "SELECT SUM(valor) AS total FROM carrinho";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);


$total = $row['total'] ?? 0;

echo json_encode($total);

mysqli_close($con);
