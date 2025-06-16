<?php
// projetosemestral/php/descriptografar.php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['payload'], $_POST['chaveCriptografada'], $_POST['iv'])) {

    // Recebe os dados do front-end
    $payloadCriptografadoEmBase64 = $_POST['payload'];
    $chaveSimetricaCriptografada = base64_decode($_POST['chaveCriptografada']);
    $iv = hex2bin($_POST['iv']);

    // Carrega a chave privada do servidor
    $caminhoChavePrivada = __DIR__ . '/../chaves/chave_privada.pem';
    $conteudoChavePrivada = file_get_contents($caminhoChavePrivada);

    if ($conteudoChavePrivada === false) {
        http_response_code(500);
        die(json_encode(['success' => false, 'message' => 'Erro interno: Não foi possível ler a chave de segurança.']));
    }
    
    $chavePrivada = openssl_pkey_get_private($conteudoChavePrivada);

    if (!$chavePrivada) {
        http_response_code(500);
        die(json_encode(['success' => false, 'message' => 'Erro interno do servidor: Falha ao carregar a chave de segurança.']));
    }

    // Decriptografa a chave simétrica (que está em formato hexadecimal)
    $chaveSimetricaHex = '';
    if (!openssl_private_decrypt($chaveSimetricaCriptografada, $chaveSimetricaHex, $chavePrivada, OPENSSL_PKCS1_PADDING)) {
        http_response_code(500);
        die(json_encode(['success' => false, 'message' => 'Falha na verificação de segurança (chave).']));
    }

    // Converte a chave hexadecimal para bytes brutos
    $chaveSimetricaBytes = hex2bin($chaveSimetricaHex);
    $payloadCriptografadoBytes = base64_decode($payloadCriptografadoEmBase64);

    // Decriptografa o payload usando a chave e o IV corretos
    $dadosDecriptografadosJson = openssl_decrypt(
        $payloadCriptografadoBytes, // Usa os bytes decodificados
        'aes-256-cbc',
        $chaveSimetricaBytes,
        OPENSSL_RAW_DATA,
        $iv
    );

    if ($dadosDecriptografadosJson === false) {
        http_response_code(500);
        die(json_encode(['success' => false, 'message' => 'Falha na verificação de segurança (payload).']));
    }

    // 7. Decodifica o JSON e substitui a variável global $_POST
    $dadosDecriptografados = json_decode($dadosDecriptografadosJson, true);
    
    if (json_last_error() === JSON_ERROR_NONE) {
        $_POST = $dadosDecriptografados;
    } else {
        http_response_code(400);
        die(json_encode(['success' => false, 'message' => 'O formato dos dados recebidos é inválido.']));
    }
}
