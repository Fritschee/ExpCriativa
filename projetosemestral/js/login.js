function login() {
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var hashedPassword = CryptoJS.SHA256(password).toString();

    var dados = new FormData();
    dados.set('email', email);
    dados.set('password', hashedPassword);

    fetch("../php/login.php", {
        method: "POST",
        body: dados
    }).then(async function(response) {
        var dados = await response.json();

        if (dados.success && dados.require_2fa) {
            sessionStorage.setItem("email", dados.email);
            sessionStorage.setItem("nome", dados.nome);
            window.location.href = "../pages/confirma-2fa.html?email=" + encodeURIComponent(dados.email);
        } else if (dados.success) {
            sessionStorage.setItem("email", dados.email);
            sessionStorage.setItem("nome", dados.nome);
            window.location.href = "../index/index.php";
        } else {
            exibirAlerta("Erro ao fazer login: " + dados.message);
        }
    }).catch(error => {
        exibirAlerta("Erro ao processar o login: " + error);
    });
}
