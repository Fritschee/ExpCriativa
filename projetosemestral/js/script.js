function gotoProducts(){
    window.location.href = "../pages/products.html"
}

function gotoIndex(){
    // IMPORTANTE: Isso deve apontar para index.php se você quiser que a página fique protegida
    window.location.href = "../index/index.php" 
}

function gotoCart(){
    window.location.href = "../pages/cart.php"
}

function gotoProfile() {
    window.location.href = "../pages/perfil.php";
}

function gotoAlterarSenha() {
    window.location.href = "../pages/forgot-password.html";
}


document.addEventListener("DOMContentLoaded", () => {
    const nome = sessionStorage.getItem("nome");
    const email = sessionStorage.getItem("email");

    const perfilNomeEl = document.getElementById("perfil-nome");
    if (perfilNomeEl) {
        perfilNomeEl.textContent = nome;
    }
    
    const perfilEmailEl = document.getElementById("perfil-email");
    if (perfilEmailEl) {
        perfilEmailEl.textContent = email;
    }
});


let idleTime = 0;

function resetIdleTime() {
    idleTime = 0;
}
document.onclick = resetIdleTime;
document.onmousemove = resetIdleTime;
document.onkeypress = resetIdleTime;
document.onscroll = resetIdleTime;

// Este intervalo verifica a inatividade do usuário a cada segundo
setInterval(() => {
    idleTime++;
    // Se o usuário estiver inativo por 60 segundos (1 * 60), redireciona para o logout
    if (idleTime >= 60) {
        window.location.href = '../php/logout.php';
    }
}, 1000);