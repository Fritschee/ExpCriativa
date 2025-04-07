function enviarEmailRecuperacao() {
    const email = document.getElementById("emailRecupera").value;
    const dados = new FormData();
    dados.set('email', email);

    fetch("../php/recover-password.php", {
        method: "POST",
        body: dados
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            exibirAlerta("E-mail enviado com instruções para redefinir sua senha.","success");
            window.location.href = "login.html";
        } else {
            alert(data.message);
        }
    })
    .catch(err => {
        alert("Erro ao enviar: ","error");
    });
}
