async function carregarCarrinho() {
    try {
        const resposta = await fetch("../php/show-carrinho.php");
        const dados = await resposta.json();
        listarCarrinho(dados);
    } catch (err) {
        console.error("Erro ao carregar carrinho:", err);
    }
}

async function carregarTotal() {
    try {
        const resposta = await fetch("../php/total-carrinho.php");
        const dados = await resposta.json();

        const totalTexto = document.createTextNode(`Total: R$ ${dados},00`);
        document.getElementById("valorTotal").appendChild(totalTexto);
    } catch (err) {
        console.error("Erro ao carregar total:", err);
    }
}

function listarCarrinho(dados) {
    const lista = document.getElementById("listaCarrinho");
    lista.innerHTML = ""; // limpa antes de inserir

    for (let i = 0; i < dados.length; i++) {
        const card = document.createElement("div");
        card.classList.add("carrinhoCard");

        const nome = document.createElement("div");
        nome.classList.add("carrinhoNome");
        nome.textContent = dados[i].nome; // evita XSS

        const valor = document.createElement("div");
        valor.classList.add("carrinhoVal");
        valor.textContent = `R$ ${dados[i].valor},00`;

        card.appendChild(nome);
        card.appendChild(valor);
        lista.appendChild(card);
    }
}

function limparCarrinho() {
    fetch("../php/clear-carrinho.php", {
        method: "POST"
    })
    .then(() => window.location.reload())
    .catch(err => console.error("Erro ao limpar carrinho:", err));
}

function gotoProducts() {
    window.location.href = "../pages/products.html";
}

function gotoIndex() {
    window.location.href = "../index/index.php";
}

function gotoProfile() {
    window.location.href = "../pages/perfil.html";
}



// Carrega tudo ao iniciar
document.addEventListener("DOMContentLoaded", () => {
    carregarCarrinho();
    carregarTotal();
});
