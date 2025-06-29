<?php
require_once '../php/session.php';
?>

<html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/cart.css" />
		<meta charset="utf-8"/>
		<script src="../js/cart.js" defer></script>
        <script src="../js/script.js" defer></script>

    </head>

    <body>
        
        <div class="areaTotal">

            <div class="header">De Kenner</div>

            <div class="menu">
				
				<div class="btnLateral">

					<img onclick="gotoIndex()" class="logo" src="../assets/logo.png" height="150px"/>

				</div>
				

				<div class="btnProdutos">

					<button onclick="gotoProducts()" class="btn">Confira nossos Produtos!</button>

				</div>

                <div class="btnLateral">
                    <button onclick="gotoProfile()" class="btn">Perfil</button>
                </div>
				
			</div>

            <div class="carrinho">

                <div class="listaCarrinho" id="listaCarrinho">
                    <div class="listaCarrinhoSpacing"></div>

                </div>

                <div class="checkout">

                    <div class="listaCarrinhoSpacing"></div>

                    <div class="checkoutCard">

                        <div class="valorTotal" id="valorTotal"></div>
                        <div>
                            <button type="submit" class="checkoutBtn" onclick="limparCarrinho()">Limpar Carrinho</button>
                        </div>
                        <div>
                            <button class="checkoutBtn" onclick="">Checkout</button>
                        </div>

                    </div>

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