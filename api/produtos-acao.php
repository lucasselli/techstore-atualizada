
<?php

header('Content-Type: application/json; charset=utf-8');

function responder($codigo, $dados)
{
    http_response_code($codigo);
    echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    exit;
}

session_start();

if (empty($_SESSION['techstore_api_token'])) {
    $_SESSION['techstore_api_token'] = getenv('TECHSTORE_API_TOKEN');
}

$token = $_SESSION['techstore_api_token'];

if (!$token) {
    responder(500, ['erro' => 'Token da API não configurado no servidor.']);
}

$entrada = json_decode(file_get_contents('php://input'), true);

if (!is_array($entrada)) {
    responder(400, ['erro' => 'Envie um JSON válido.']);
}

$metodo = $_SERVER['REQUEST_METHOD'];

if (!in_array($metodo, ['POST', 'PUT', 'DELETE'], true)) {
    header('Allow: POST, PUT, DELETE');
    responder(405, ['erro' => 'Método não permitido.']);
}

if ($metodo === 'DELETE') {
    $id = filter_var($entrada['id'] ?? null, FILTER_VALIDATE_INT);

    if (!$id || $id < 1) {
        responder(400, ['erro' => 'ID inválido.']);
    }

    $url = 'http://localhost/techstore/api/produtos.php?id=' . $id;
    $corpo = null;
} else {
    $id = null;

    if ($metodo === 'PUT') {
        $id = filter_var($entrada['id'] ?? null, FILTER_VALIDATE_INT);

        if (!$id || $id < 1) {
            responder(400, ['erro' => 'ID inválido.']);
        }
    }

    $dados = $entrada['produto'] ?? null;

    if (!is_array($dados)) {
        responder(400, ['erro' => 'Dados do produto não informados.']);
    }

    $url = 'http://localhost/techstore/api/produtos.php';

    if ($metodo === 'PUT') {
        $url .= '?id=' . $id;
    }

    $corpo = json_encode($dados, JSON_UNESCAPED_UNICODE);
}

$curl = curl_init($url);

$opcoes = [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => $metodo,
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json'
    ],
    CURLOPT_TIMEOUT => 10
];

if ($corpo !== null) {
    $opcoes[CURLOPT_POSTFIELDS] = $corpo;
}

curl_setopt_array($curl, $opcoes);

$resposta = curl_exec($curl);

if ($resposta === false) {
    curl_close($curl);
    responder(502, ['erro' => 'Não foi possível comunicar com a API.']);
}

$codigo = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

http_response_code($codigo);
echo $resposta;
