<?php
require_once '../php/session.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja De Kenner</title>
    <link rel="stylesheet" href="../css/index.css" />
    <script src="../js/script.js" defer></script>
    <link rel="stylesheet" href="../css/alerta.css">
    <script src="../js/alerta.js"></script>
</head>

<body>

    <div class="areaTotal">


        <div class="menu">

            <div class="btnLateral">
                <img onclick="gotoIndex()" class="logo" src="../assets/logo.png" height="150px" />
            </div>

            <div class="btnProdutos">
                <button onclick="gotoProducts()" class="btn">Confira nossos Produtos!</button>
            </div>

            <div class="btnLateral">
                <button onclick="gotoCart()" class="btn">Carrinho</button>
            </div>

            <div class="btnLateral">
                <button onclick="gotoProfile()" class="btn">Perfil</button>
            </div>

        </div>

        <div class="clientesTitulo">Conheça a opinião de alguns de nossos clientes:</div>

        <div class="clientes">
            <div class="card">
                <div class="cardImagem">
                    <img src="../assets/juliet-sacy.jpg" height="100%">
                </div>
                <div class="cardNome">Sacy</div>
                <div class="cardTexto">"Loja sensacional, só ganhei a champions porque tava jogando De Kenner no pé."</div>
            </div>

            <div class="card">
                <div class="cardImagem">
                    <img src="../assets/juliet-fbc.png" height="100%">
                </div>
                <div class="cardNome">FBC</div>
                <div class="cardTexto">"De Kenner"</div>
            </div>

            <div class="card">
                <div class="cardImagem">
                    <img src="../assets/juliet-jordan.png" height="100%">
                </div>
                <div class="cardNome">Michael Jordan</div>
                <div class="cardTexto">"Eu fui campeão 6 vezes e mesmo assim uso juliet."</div>
            </div>

            <div class="card">
                <div class="cardImagem">
                    <img src="../assets/juliet-messi.jpg" height="100%">
                </div>
                <div class="cardNome">Lionel Messi</div>
                <div class="cardTexto">"9 em 10 tão com a minha camisa."</div>
            </div>
        </div>

        <div class="clientesTitulo">Endereço e contato:</div>

        <div class="contato">
            <div class="contatoCard">
                <img class="contatoCardImg" src="../assets/icon-endereco.png" height="80%">
                <div class="contatoCardTexto">R. Imac. Conceição, 1206 - Prado Velho, Curitiba - PR, 80215-901</div>
            </div>

            <div class="contatoCard">
                <img class="contatoCardImg" src="../assets/icon-telefone.png" height="80%">
                <div class="contatoCardTexto">+55 41 99839-6143</div>
            </div>
        </div>

        <div class="rodape">
            <div class="rodapeCard">
                <img class="rodapeImg" src="../assets/icon-facebook.png" height="50%">
                <div class="rodapeTexto">@LojaDeKenner</div>
            </div>

            <div class="rodapeCard">
                <img class="rodapeImg" src="../assets/icon-instagram.png" height="50%">
                <div class="rodapeTexto">@LojaDeKenner</div>
            </div>

            <div class="rodapeCard">
                <img class="rodapeImg" src="../assets/icon-twitter.png" height="50%">
                <div class="rodapeTexto">@LojaDeKenner</div>
            </div>

            <div class="rodapeCard">
                <img class="rodapeImg" src="../assets/icon-pinterest.png" height="50%">
                <div class="rodapeTexto">@LojaDeKenner</div>
            </div>
        </div>

    </div>

</body>

</html>
