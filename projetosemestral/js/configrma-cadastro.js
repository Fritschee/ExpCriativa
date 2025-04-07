document.addEventListener("DOMContentLoaded", () => {
    const destino = document.body.dataset.redirect;

    if (destino) {
        setTimeout(() => {
            window.location.href = destino;
        }, 3000);
    }
});
