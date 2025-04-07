<?php
require_once '../lib/GoogleAuthenticator/PHPGangsta/GoogleAuthenticator.php';
include "conexao.php";

if (isset($_POST['email'], $_POST['code'])) {
    $email = $_POST['email'];
    $code = $_POST['code'];

    $stmt = mysqli_prepare($con, "SELECT secret_2fa FROM usuario WHERE email = ?");
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    mysqli_close($con);

    $g = new PHPGangsta_GoogleAuthenticator();
    $check = $g->verifyCode($row['secret_2fa'], $code, 2);

    echo json_encode(['success' => $check]);
}
