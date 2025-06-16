async function criptografarDados(dados) {
    try {
        const response = await fetch('../php/obter_chave_publica.php');
        if (!response.ok) {
            throw new Error('Falha ao buscar a chave pública de segurança do servidor.');
        }
        const chavePublica = await response.text();

        // 1. Gera uma chave simétrica e um Vetor de Inicialização (IV) aleatórios.
        const chaveSimetrica = CryptoJS.lib.WordArray.random(32); 
        const iv = CryptoJS.lib.WordArray.random(16);             

    
        const dadosEmJson = JSON.stringify(dados);
        const payloadCriptografado = CryptoJS.AES.encrypt(dadosEmJson, chaveSimetrica, {
            iv: iv,
            mode: CryptoJS.mode.CBC,
            padding: CryptoJS.pad.Pkcs7
        }).toString(); 

        // 4. Criptografa a chave simétrica usando a chave pública (RSA).
        const rsaEncrypt = new JSEncrypt();
        rsaEncrypt.setPublicKey(chavePublica);
        const chaveSimetricaCriptografada = rsaEncrypt.encrypt(chaveSimetrica.toString(CryptoJS.enc.Hex));

        if (!chaveSimetricaCriptografada) {
            throw new Error('A criptografia da chave de sessão falhou. Verifique a chave pública.');
        }
        
        // 5. Monta o FormData para o envio.
        const formData = new FormData();
        formData.append('payload', payloadCriptografado);
        formData.append('chaveCriptografada', chaveSimetricaCriptografada);
        formData.append('iv', iv.toString(CryptoJS.enc.Hex)); // O IV é enviado como hexadecimal

        return formData;

    } catch (error) {
        console.error("Erro crítico no processo de criptografia:", error);
        exibirAlerta("Ocorreu um erro de segurança. A comunicação não pôde ser estabelecida.", "error");
        throw error;
    }
}
