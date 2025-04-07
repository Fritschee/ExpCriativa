function getEmailFromUrl() {
    const params = new URLSearchParams(window.location.search);
    return params.get("email");
}

function confirmar2FA() {
    const email = getEmailFromUrl();
    const code = document.getElementById("code").value;

    const dados = new FormData();
    dados.set('email', email);
    dados.set('code', code);

    fetch("../php/verificar-2fa.php", {
        method: "POST",
        body: dados
    }).then(res => res.json())
      .then(data => {
          if (data.success) {
              window.location.href = "../index/index.html";
          } else {
              alert("Código inválido. Tente novamente.");
          }
      })
      .catch(err => {
          alert("Erro: " + err);
      });
}
