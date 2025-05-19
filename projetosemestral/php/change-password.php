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
include "conexao.php";

if (isset($_POST['token']) && isset($_POST['novaSenha'])) {
    $token = mysqli_real_escape_string($con, $_POST['token']);
    $novaSenha = mysqli_real_escape_string($con, $_POST['novaSenha']);

    $sql = "SELECT email FROM usuario WHERE token = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 's', $token);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($usuario = mysqli_fetch_assoc($result)) {
        $sqlUpdate = "UPDATE usuario SET senha = ?, token = NULL WHERE email = ?";
        $stmtUpdate = mysqli_prepare($con, $sqlUpdate);
        mysqli_stmt_bind_param($stmtUpdate, 'ss', $novaSenha, $usuario['email']);
        mysqli_stmt_execute($stmtUpdate);

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Token inválido ou expirado.']);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);
} else {
    echo json_encode(['success' => false, 'message' => 'Dados incompletos.']);
}
