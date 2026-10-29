
<?php

header('Content-Type: application/json; charset=utf-8');

try {
    $token = getenv('TECHSTORE_API_TOKEN');

    if (!$token) {
        http_response_code(500);
        echo json_encode(['erro' => 'Token da API não configurado.']);
        exit;
    }

    $curl = curl_init('http://localhost/techstore/api/categorias.php');

    curl_setopt_array($curl, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . $token
        ],
        CURLOPT_TIMEOUT => 10
    ]);

    $resposta = curl_exec($curl);

    if ($resposta === false) {
        curl_close($curl);
        throw new RuntimeException('Falha ao consultar categorias.');
    }

    $codigo = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    http_response_code($codigo);
    echo $resposta;

} catch (Throwable $e) {
    error_log($e->getMessage());
    http_response_code(500);
    echo json_encode(['erro' => 'Não foi possível carregar as categorias.']);
}
