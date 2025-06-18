/**
 * Lida com o processo de login do usuário.
 * Esta função agora é assíncrona para aguardar o processo de criptografia.
 * Ela captura as credenciais do usuário, gera o hash da senha, criptografa o conteúdo
 * e o envia para o servidor.
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

        // 4. Enviar os dados criptografados para o endpoint de login.
        const response = await fetch("../php/login.php", {
            method: "POST",
            body: dadosParaEnviar
        });
        
        const dadosResposta = await response.json();

        if (dadosResposta.success) {
            sessionStorage.setItem("email", dadosResposta.email);
            sessionStorage.setItem("nome", dadosResposta.nome);

            if (dadosResposta.require_2fa) {
                // Redireciona para a página de confirmação de 2FA, se necessário
                window.location.href = `../pages/confirma-2fa.html?email=${encodeURIComponent(dadosResposta.email)}`;
            } else {
                // Redireciona para a página principal após login bem-sucedido
                window.location.href = "../index/index.php";
            }
        } else {
            exibirAlerta("Erro ao fazer login: " + dadosResposta.message, "error");
        }
    } catch (error) {
        // Capturar e exibir os erros que ocorrem durante a criptografia ou comunicação.
        console.error("Falha na operação de login:", error);
        exibirAlerta("Falha de comunicação: " + error.message, "error");
    }
}
