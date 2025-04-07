function gravar() {
    var form = document.getElementById("formCadastro");
    var nome = document.getElementById("nome").value;
    var cpf = document.getElementById("cpf").value.replace(/[\.\-]/g, ""); // Remove pontos e traços automaticamente
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var passwordConfirm = document.getElementById("passwordconfirm").value;

    function isStrongPassword(password) {
        var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$!%*?&])[A-Za-z\d@#$!%*?&]{12,}$/;
        return regex.test(password);
    }

    function isValidEmail(email) {
        var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    function isValidCPF(cpf) {
        if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) return false;
        
        var soma = 0, resto;
        for (var i = 1; i <= 9; i++) soma += parseInt(cpf[i - 1]) * (11 - i);
        resto = (soma * 10) % 11;
        if (resto === 10 || resto === 11) resto = 0;
        if (resto !== parseInt(cpf[9])) return false;
        
        soma = 0;
        for (var i = 1; i <= 10; i++) soma += parseInt(cpf[i - 1]) * (12 - i);
        resto = (soma * 10) % 11;
        if (resto === 10 || resto === 11) resto = 0;
        if (resto !== parseInt(cpf[10])) return false;
        
        return true;
    }

    if (!isValidEmail(email)) {
        exibirAlerta("E-mail inválido.", "error");
        return;
    }

    if (!isValidCPF(cpf)) {
        exibirAlerta("CPF inválido.", "error");
        return;
    }

    if (!isStrongPassword(password)) {
        exibirAlerta("A senha deve ter no mínimo 12 caracteres, incluindo letras maiúsculas, minúsculas, números e caracteres especiais.", "warning");
        return;
    }

    var hashedPassword = CryptoJS.SHA256(password).toString();
    var hashedPasswordconfirm = CryptoJS.SHA256(passwordConfirm).toString();

    if (hashedPassword !== hashedPasswordconfirm) {
        exibirAlerta("As senhas não são iguais.", "error");
        return;
    }

    var dados = new FormData(form);
    dados.set('cpf', cpf);
    dados.set('password', hashedPassword);
    dados.delete('passwordconfirm');

    const botaoRegistrar = document.querySelector('.submit');
    botaoRegistrar.disabled = true;
    botaoRegistrar.textContent = 'Registrando, aguarde...';

    fetch("../php/insere-registro.php", {
        method: "POST",
        body: dados
    }).then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = "../pages/configurar-2fa.html?email=" + encodeURIComponent(email);
        } else {
            exibirAlerta("Erro ao registrar: " + data.message, "error");
        }
    }).catch(error => {
        exibirAlerta("Erro ao processar o registro: " + error, "error");
    }).finally(() => {
        botaoRegistrar.disabled = false;
        botaoRegistrar.textContent = 'Registrar';
    });
}
