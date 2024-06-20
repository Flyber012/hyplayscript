<?php
// Configuração de CORS para permitir acesso a partir de qualquer origem
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, x-session-authorization");
header("Access-Control-Allow-Credentials: true");

// Manipulador de requisição OPTIONS (preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// Obter todos os parâmetros da URL
$parametros = $_GET;

// Define um valor padrão caso nenhum parâmetro seja passado
$dados_padrao = array(
    'publicState' => array(
        'gold' => 25 // Valor padrão para "gold"
    )
);

// Mescla os dados padrão com os parâmetros da URL, sobrescrevendo os valores padrão se necessário
$dados = array_merge($dados_padrao, $parametros);

// URL do destino
$url_destino = "https://api.hyplay.com/v1/apps/2506faed-d667-4570-9b28-6f96b6ba2af2/states";

// Dados para a requisição POST (agora usando os dados mesclados)
$data = json_encode(array(
    'publicState' => $dados
));

// Cabeçalhos da requisição (agora incluindo x-session-authorization se existir)
$headers = array(
    "Content-Type: application/json"
);
if (isset($_SERVER['HTTP_X_SESSION_AUTHORIZATION'])) {
    $headers[] = "x-session-authorization: " . $_SERVER['HTTP_X_SESSION_AUTHORIZATION'];
}

// Configuração da requisição cURL (sem alterações)
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url_destino);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// Executa a requisição (sem alterações)
$response = curl_exec($ch);

// Verifica se houve erro na requisição cURL
if (curl_errno($ch)) {
    echo 'Erro na requisição cURL: ' . curl_error($ch);
} else {
    // Imprime a resposta da API (sem alterações)
    echo $response;
}

curl_close($ch);
?>
