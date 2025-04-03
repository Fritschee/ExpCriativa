<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-6.9.3/src/Exception.php';
require '../PHPMailer-6.9.3/src/PHPMailer.php';
require '../PHPMailer-6.9.3/src/SMTP.php';

if (isset($_POST['nome'], $_POST['cpf'], $_POST['email'], $_POST['password'])) {

    include "conexao.php";

    $nome = mysqli_real_escape_string($con, $_POST['nome']);
    $cpf = mysqli_real_escape_string($con, $_POST['cpf']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    $token = bin2hex(random_bytes(32));

    $sql = "INSERT INTO usuario (email, nome, cpf, senha, token, confirmado) VALUES (?, ?, ?, ?, ?, false)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'sssss', $email, $nome, $cpf, $password, $token);

    if (mysqli_stmt_execute($stmt)) {

        $mail = new PHPMailer(true);
        
        try {
            // Configuração SMTP Gmail para envio de e-mails
            $mail->isSMTP();
            $mail->CharSet = 'UTF-8';
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 587;

            $mail->Username = 'kauancornelsen2@gmail.com';
            $mail->Password = 'qkxyiucozppopmox';

            $mail->setFrom('kauancornelsen2@gmail.com', 'Suporte do Sistema');
            $mail->addAddress($email, $nome);

            $mail->isHTML(true);
            $mail->Subject = 'Confirme seu cadastro';
            $mail->Body = '
                <h3>Olá, ' . htmlspecialchars($nome) . '!</h3>
                <p>Para concluir seu cadastro, clique no link abaixo:</p>
                <a href="http://localhost/ExpCriativa/projetosemestral/php/confirma-cadastro.php?token=' . $token . '">
                Confirmar Cadastro</a>
                <br><br>
                <small>Se você não solicitou este cadastro, ignore esta mensagem.</small>';

            $mail->send();

            echo json_encode(['success' => true]);

        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erro ao enviar e-mail.']);
        }

    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao registrar no banco de dados.']);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);

} else {
    echo json_encode(['success' => false, 'message' => 'Dados incompletos.']);
}
