function exibirAlerta(mensagem, tipo = "info") {
    const alerta = document.createElement("div");
    alerta.className = `alerta ${tipo}`;
    alerta.textContent = mensagem;

    document.body.appendChild(alerta);

    setTimeout(() => {
        alerta.classList.add("mostrar");
    }, 100); // pequena transição de entrada

    setTimeout(() => {
        alerta.classList.remove("mostrar");
        setTimeout(() => alerta.remove(), 500);
    }, 3000); // desaparece após 3s
}
