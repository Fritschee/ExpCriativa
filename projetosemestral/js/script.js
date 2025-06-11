function gotoProducts(){
    window.location.href = "../pages/products.html"
}

function gotoIndex(){
    // IMPORTANT: This must point to index.php if you want the page to be protected
    window.location.href = "../index/index.php" 
}

function gotoCart(){
    window.location.href = "../pages/cart.html"
}

function gotoProfile() {
    window.location.href = "../pages/perfil.html";
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

// This interval checks for user inactivity every second
setInterval(() => {
    idleTime++;
    // If user is idle for 60 seconds (1 * 60), redirect to logout
    if (idleTime >= 60) {
        window.location.href = '../php/logout.php';
    }
}, 1000);