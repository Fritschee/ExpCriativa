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
require_once '../lib/GoogleAuthenticator/PHPGangsta/GoogleAuthenticator.php';
include "conexao.php";

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    $g = new PHPGangsta_GoogleAuthenticator();
    $secret = $g->createSecret();

    $issuer = 'ProjetoSeguranca';
    $otpauth = "otpauth://totp/{$issuer}:{$email}?secret={$secret}&issuer={$issuer}";

    $stmt = mysqli_prepare($con, "UPDATE usuario SET `secret_2fa` = ? WHERE email = ?");
    mysqli_stmt_bind_param($stmt, 'ss', $secret, $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($con);

    echo json_encode(['secret' => $secret, 'otpauth_url' => $otpauth]);
}
