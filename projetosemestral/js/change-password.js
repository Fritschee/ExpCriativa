function getToken() {
    const params = new URLSearchParams(window.location.search);
    return params.get("token");
}

function redefinirSenha() {
    const senha = document.getElementById("novaSenha").value;
    const confirma = document.getElementById("confirmaSenha").value;

    if (senha !== confirma) {
        alert("As senhas não coincidem.");
        return;
    }

    const token = getToken();
    if (!token) {
        alert("Token inválido.");
        return;
    }

    const hashed = CryptoJS.SHA256(senha).toString();
    const dados = new FormData();
    dados.set('token', token);
    dados.set('novaSenha', hashed);

    fetch("../php/change-password.php", {
        method: "POST",
        body: dados
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert("Senha alterada com sucesso.");
            window.location.href = "login.html";
        } else {
            alert(data.message);
        }
    })
    .catch(err => {
        alert("Erro ao redefinir senha: " + err);
    });
}
