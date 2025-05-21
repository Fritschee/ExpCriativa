<?php
// conexao.php
$env = include __DIR__ . '/env.php';

$host     = $env['DB_HOST'];
$dbname   = $env['DB_NAME'];
$user     = $env['DB_USER'];
$password = $env['DB_PASSWORD'];

$con = new mysqli($host, $user, $password, $dbname);

if ($con->connect_error) {
    die("Erro de conexão ({$con->connect_errno}): " . $con->connect_error);
}
?>
