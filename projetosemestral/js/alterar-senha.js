document.getElementById("formAlterarSenha").addEventListener("submit", function (event) {
    event.preventDefault();

    var senhaAtual = document.getElementById("senhaAtual").value;
    var novaSenha = document.getElementById("novaSenha").value;
    var confirmarNovaSenha = document.getElementById("confirmarNovaSenha").value;

    // Verifica se as senhas novas são iguais
    if (novaSenha !== confirmarNovaSenha) {
        alert("As novas senhas não coincidem.");
        return;
    }

    // Verifica se a senha atende aos requisitos de segurança
    function isStrongPassword(password) {
        var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$!%*?&])[A-Za-z\d@#$!%*?&]{12,}$/;
        return regex.test(password);
    }

    if (!isStrongPassword(novaSenha)) {
        alert("A nova senha deve ter no mínimo 12 caracteres, incluindo letras maiúsculas, minúsculas, números e caracteres especiais.");
        return;
    }

    // Gera os hashes das senhas
    var senhaAtualHash = CryptoJS.SHA256(senhaAtual).toString();
    var novaSenhaHash = CryptoJS.SHA256(novaSenha).toString();

    // Envia os dados para o servidor via fetch API
    fetch("alterar-senha.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            senhaAtual: senhaAtualHash,
            novaSenha: novaSenhaHash
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Senha alterada com sucesso! Faça login novamente.");
            window.location.href = "login.html";
        } else {
            alert("Erro ao alterar senha: " + data.message);
        }
    })
    .catch(error => {
        alert("Erro ao processar a solicitação.");
        console.error("Erro:", error);
    });
});
