function gotoProducts(){
    window.location.href = "../pages/products.html"
}

function gotoIndex(){
    window.location.href = "../index/index.html"
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

    if (!nome || !email) {
        window.location.href = "../pages/login.html";
        return;
    }

    document.getElementById("perfil-nome").textContent = nome;
    document.getElementById("perfil-email").textContent = email;
});


let idleTime = 0;

function resetIdleTime() {
    idleTime = 0;
}
document.onclick = resetIdleTime;
document.onmousemove = resetIdleTime;
document.onkeypress = resetIdleTime;
document.onscroll = resetIdleTime;

setInterval(() => {
    idleTime++;
    if (idleTime >= 1 * 60) {
        window.location.href = '../php/logout.php';
    }
}, 1000);
