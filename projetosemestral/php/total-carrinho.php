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

$sql = "SELECT SUM(valor) AS total FROM carrinho";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);


$total = $row['total'] ?? 0;

echo json_encode($total);

mysqli_close($con);
