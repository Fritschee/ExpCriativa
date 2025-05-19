<?php
session_start();
$timeout = 300; // 5 minutos

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $timeout)) {
    session_unset();
    session_destroy();
    header("Location: ../pages/login.html");
    exit();
}
$_SESSION['LAST_ACTIVITY'] = time();
?>
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
