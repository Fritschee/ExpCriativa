<?php
session_start();
header("Content-Type: application/json");
require_once "conexao.php"; // Arquivo de conexão com o banco de dados

// Verifica se o usuário está logado (deve haver uma sessão ativa)
if (!isset($_SESSION['email'])) {
    echo json_encode(["success" => false, "message" => "Usuário não autenticado."]);
    exit;
}

$email = $_SESSION['email']; // Obtém o e-mail do usuário logado
$dados = json_decode(file_get_contents("php://input"), true);

$senhaAtual = $dados['senhaAtual'];
$novaSenha = $dados['novaSenha'];

// Busca a senha atual no banco de dados
$sql = "SELECT senha FROM usuario WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["success" => false, "message" => "Usuário não encontrado."]);
    exit;
}

$row = $result->fetch_assoc();
$senhaBanco = $row['senha'];

// Verifica se a senha informada bate com a do banco
if ($senhaAtual !== $senhaBanco) {
    echo json_encode(["success" => false, "message" => "Senha atual incorreta."]);
    exit;
}

// Atualiza a senha no banco de dados
$sqlUpdate = "UPDATE usuario SET senha = ? WHERE email = ?";
$stmtUpdate = $conn->prepare($sqlUpdate);
$stmtUpdate->bind_param("ss", $novaSenha, $email);

if ($stmtUpdate->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Erro ao atualizar a senha."]);
}

$conn->close();
?>
