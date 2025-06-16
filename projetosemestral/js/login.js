/**
 * Handles the user login process.
 * This function is now async to await the encryption process.
 * It captures user credentials, hashes the password, encrypts the payload,
 * and sends it to the server.
 */
async function login() {
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
    const hashedPassword = CryptoJS.SHA256(password).toString();

    const dadosOriginais = {
        email: email,
        password: hashedPassword
    };

    try {
        const dadosParaEnviar = await criptografarDados(dadosOriginais);

        // 4. Send the encrypted data to the login endpoint.
        const response = await fetch("../php/login.php", {
            method: "POST",
            body: dadosParaEnviar
        });
        
        const dadosResposta = await response.json();

        if (dadosResposta.success) {
            sessionStorage.setItem("email", dadosResposta.email);
            sessionStorage.setItem("nome", dadosResposta.nome);

            if (dadosResposta.require_2fa) {
                // Redirect to 2FA confirmation page if required
                window.location.href = `../pages/confirma-2fa.html?email=${encodeURIComponent(dadosResposta.email)}`;
            } else {
                // Redirect to the main page upon successful login
                window.location.href = "../index/index.php";
            }
        } else {
            exibirAlerta("Erro ao fazer login: " + dadosResposta.message, "error");
        }
    } catch (error) {
        // Catch and display any errors that occur during encryption or communication.
        console.error("Falha na operação de login:", error);
        exibirAlerta("Falha de comunicação: " + error.message, "error");
    }
}
