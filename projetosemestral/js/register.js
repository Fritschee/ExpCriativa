function gravar() {
    var form = document.getElementById("formCadastro");
    var nome = document.getElementById("nome").value;
    var cpf = document.getElementById("cpf").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var passwordConfirm = document.getElementById("passwordconfirm").value;

    function isStrongPassword(password) {
        var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$#!%*?&])[A-Za-z\d@$#!%*?&]{12,}$/;
        return regex.test(password);
    }

    if (!isStrongPassword(password)) {
        alert("A senha deve ter no mínimo 12 caracteres, incluindo letras maiúsculas, minúsculas, números e caracteres especiais.");
        return;
    }

    var hashedPassword = CryptoJS.SHA256(password).toString();
    var hashedPasswordconfirm = CryptoJS.SHA256(passwordConfirm).toString();

    if (hashedPassword !== hashedPasswordconfirm) {
        alert("As senhas não são iguais.");
        return;
    }

    var dados = new FormData(form);
    dados.set('password', hashedPassword);
    dados.delete('passwordconfirm');

    // Mostra uma mensagem ao usuário enquanto espera
    const botaoRegistrar = document.querySelector('.submit');
    botaoRegistrar.disabled = true;
    botaoRegistrar.textContent = 'Registrando, aguarde...';

    fetch("../php/insere-registro.php", {
        method: "POST",
        body: dados
    }).then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = "../pages/login.html";
        } else {
            alert("Erro ao registrar: " + data.message);
        }
    }).catch(error => {
        alert("Erro ao processar o registro: " + error);
    }).finally(() => {
        botaoRegistrar.disabled = false;
        botaoRegistrar.textContent = 'Registrar';
    });
}
