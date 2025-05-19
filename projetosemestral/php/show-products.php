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

$sql = "SELECT * from produto";

$resultado = mysqli_query($con, $sql);

$i = 0;

while($registro = mysqli_fetch_assoc($resultado)) {
    $data[$i]["nome"] = $registro["nome"];
    $data[$i]["descricao"] = $registro["descricao"];
    $data[$i]["valor"] = $registro["valor"];
    $i++;

}

$objectjSON = json_encode($data);
echo $objectjSON;

?>