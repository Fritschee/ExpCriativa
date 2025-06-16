<?php
header("Content-Type: text/plain");

// Caminho para o arquivo da chave pública
$caminhoChavePublica = __DIR__ . '/../chaves/chave_publica.pem';

// Verifica se o arquivo da chave pública existe
if (file_exists($caminhoChavePublica)) {
    // Se existir, lê e envia o conteúdo da chave pública
    echo file_get_contents($caminhoChavePublica);
} else {
    // Se não existir, retorna um erro 500
    header("HTTP/1.1 500 Internal Server Error");
    echo "Erro Crítico: O arquivo da chave pública não foi encontrado no servidor.";
}
?>
