<?php
include 'env.php';

$host = "localhost";
$user = "root";
$password = getenv("DB_PASSWORD");
$dbname = "projetosemestral";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}
