<?php
require_once '../php/session.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="../css/perfil.css">
    <script src="../js/script.js" defer></script>
</head>

<body>

    <div class="areaTotal">


        <div class="menu">
            <div class="btnLateral">
                <img onclick="gotoIndex()" class="logo" src="../assets/logo.png" height="150px" />
            </div>

            <div class="btnLateral">
                <button onclick="gotoProducts()" class="btn">Produtos</button>
            </div>

            <div class="btnLateral">
                <button onclick="gotoCart()" class="btn">Carrinho</button>
            </div>
        </div>

        <div class="perfil-container">
            <div class="clientesTitulo">Dados da Conta</div>


            <button onclick="gotoAlterarSenha()" class="btn perfil-botao">Alterar Senha</button>
        </div>

    </div>

</body>

</html>
