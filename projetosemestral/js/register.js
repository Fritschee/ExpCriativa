function gravar() {
    var form = document.getElementById("formCadastro");
    var nome = document.getElementById("nome").value;
    var cpf = document.getElementById("cpf").value.replace(/[\.\-]/g, ""); // Remove pontos e traços automaticamente
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var passwordConfirm = document.getElementById("passwordconfirm").value;

    // Função para validar senha forte
    function isStrongPassword(password) {
        var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,}$/;
        return regex.test(password);
    }

    // Função para validar e-mail
    function isValidEmail(email) {
        var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    // Função para validar CPF
    function isValidCPF(cpf) {
        if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) return false; // Verifica sequência repetida
        
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
        alert("E-mail inválido.");
        return;
    }

    if (!isValidCPF(cpf)) {
        alert("CPF inválido.");
        return;
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
    dados.set('cpf', cpf); // Envia o CPF sem pontos e traços
    dados.set('password', hashedPassword);
    dados.delete('passwordconfirm');

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
    });
}
