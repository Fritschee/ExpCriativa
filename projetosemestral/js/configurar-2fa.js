function getEmailFromUrl() {
    const params = new URLSearchParams(window.location.search);
    return params.get("email");
}

let secretGlobal = "";

document.addEventListener("DOMContentLoaded", () => {
    const email = getEmailFromUrl();

    fetch("../php/gerar-secret.php", {
        method: "POST",
        body: new URLSearchParams({ email: email })
    })
    .then(res => res.json())
    .then(data => {
        secretGlobal = data.secret;
        document.getElementById("secretText").innerText = "Chave secreta: " + secretGlobal;

        const qr = new QRious({
            element: document.getElementById("qrcode"),
            size: 200,
            value: data.otpauth_url
        });
    });
});

function validar2FA() {
    const code = document.getElementById("code").value;
    const email = getEmailFromUrl();

    const dados = new FormData();
    dados.set('email', email);
    dados.set('code', code);

    fetch("../php/validar-2fa.php", {
        method: "POST",
        body: dados
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            exibirAlerta("2FA configurado com sucesso!", "success");
            window.location.href = "../pages/login.php";
        } else {
            exibirAlerta("Código inválido. Tente novamente.", "error");
        }
    });
}
