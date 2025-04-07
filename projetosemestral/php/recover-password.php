<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-6.9.3/src/Exception.php';
require '../PHPMailer-6.9.3/src/PHPMailer.php';
require '../PHPMailer-6.9.3/src/SMTP.php';
include "conexao.php";

if (isset($_POST['email'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);

    $sql = "SELECT token, confirmado FROM usuario WHERE email = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($usuario = mysqli_fetch_assoc($result)) {
        if ($usuario['confirmado']) {
            $token = bin2hex(random_bytes(32));
            $sqlUpdate = "UPDATE usuario SET token = ? WHERE email = ?";
            $stmtUpdate = mysqli_prepare($con, $sqlUpdate);
            mysqli_stmt_bind_param($stmtUpdate, 'ss', $token, $email);
            mysqli_stmt_execute($stmtUpdate);

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->CharSet = 'UTF-8';
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = 'tls';
                $mail->Host = "smtp.gmail.com";
                $mail->Port = 587;

                $mail->Username = 'kauancornelsen2@gmail.com';
                $mail->Password = 'qkxyiucozppopmox';

                $mail->setFrom('kauancornelsen2@gmail.com', 'Suporte');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Recuperação de senha';
                $mail->Body = '
                    <h3>Olá!</h3>
                    <p>Para redefinir sua senha, clique no link abaixo:</p>
                    <a href="http://localhost/projetosemestral/pages/change-password.html?token=' . $token . '">Redefinir Senha</a>
                    <p>Se você não solicitou isso, ignore este e-mail.</p>';

                $mail->send();
                echo json_encode(['success' => true]);
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Erro ao enviar e-mail.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Conta não confirmada.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'E-mail não cadastrado.']);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);
} else {
    echo json_encode(['success' => false, 'message' => 'E-mail não enviado.']);
}
