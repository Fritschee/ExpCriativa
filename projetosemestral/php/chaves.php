<?php
// set OPENSSL_CONF=D:\xampp\apache\conf\openssl.cnf
// D:\xampp\php\php.exe php/chaves.php

// No caso do disco C: ->   C:\xampp\php\php.exe C:\xampp\htdocs\projetosemestral\php\chaves.php

// Configurações para a geração da chave RSA
$config = [
    "digest_alg" => "sha256",
    "private_key_bits" => 2048,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
];

// Gera o novo par de chaves (pública e privada)
$recursoChave = openssl_pkey_new($config);

if (!$recursoChave) {
    die("Falha ao gerar o par de chaves: " . openssl_error_string());
}

// Extrai a chave privada do recurso
openssl_pkey_export($recursoChave, $chavePrivada);

// Extrai os detalhes e a chave pública
$detalhesChave = openssl_pkey_get_details($recursoChave);
$chavePublica = $detalhesChave["key"];

$diretorioChaves = __DIR__ . '/../chaves/';
if (!is_dir($diretorioChaves)) {
    // Cria o diretório caso não exista
    mkdir($diretorioChaves, 0755, true);
}

// Caminhos completos para os arquivos das chaves
$caminhoChavePrivada = $diretorioChaves . 'chave_privada.pem';
$caminhoChavePublica = $diretorioChaves . 'chave_publica.pem';

// Salva as chaves nos respectivos arquivos
file_put_contents($caminhoChavePrivada, $chavePrivada);
file_put_contents($caminhoChavePublica, $chavePublica);

echo "Par de chaves (pública e privada) gerado com sucesso em: " . realpath($diretorioChaves) . "\n";
?>
