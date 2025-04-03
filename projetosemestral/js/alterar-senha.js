document.getElementById("formAlterarSenha").addEventListener("submit", function (event) {
    event.preventDefault();

    var senhaAtual = document.getElementById("senhaAtual").value;
    var novaSenha = document.getElementById("novaSenha").value;
    var confirmarNovaSenha = document.getElementById("confirmarNovaSenha").value;

    // Função para validar senha forte
    function isStrongPassword(password) {
        var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d)(?=.*[@$!%*?&])[A-Za-z\\d@$!%*?&]{12,}$/;
        return regex.test(password);
    }

    if (!isStrongPassword(novaSenha)) {
        alert("A nova senha deve ter no mínimo 12 caracteres, incluindo letras maiúsculas, minúsculas, números e caracteres especiais.");
        return;
    }

    if (novaSenha !== confirmarNovaSenha) {
        alert("As senhas não coincidem.");
        return;
    }

    var hashedSenhaAtual = CryptoJS.SHA256(senhaAtual).toString();
    var hashedNovaSenha = CryptoJS.SHA256(novaSenha).toString();

    fetch("../php/alterar-senha.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ senhaAtual: hashedSenhaAtual, novaSenha: hashedNovaSenha })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Senha alterada com sucesso!");
            window.location.href = "login.html";
        } else {
            alert("Erro ao alterar senha: " + data.message);
        }
    })
    .catch(error => {
        alert("Erro ao processar a solicitação: " + error);
    });
});
