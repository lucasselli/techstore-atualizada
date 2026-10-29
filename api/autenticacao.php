<?php

function verificarToken()
{
    $cabecalho = '';

    if (function_exists('getallheaders')) {
        $cabecalhos = getallheaders();

        $cabecalho = $cabecalhos['Authorization']
            ?? $cabecalhos['authorization']
            ?? '';
    }

    if (empty($cabecalho) && isset($_SERVER['HTTP_AUTHORIZATION'])) {
        $cabecalho = $_SERVER['HTTP_AUTHORIZATION'];
    }

    if (!preg_match('/Bearer\s+(.+)/i', $cabecalho, $matches)) {
        http_response_code(401);

        echo json_encode([
            'erro' => 'Token não informado.'
        ]);

        exit;
    }

    $token = trim($matches[1]);
    $tokenValido = getenv('TECHSTORE_API_TOKEN');

    if (!$tokenValido || !hash_equals($tokenValido, $token)) {
        http_response_code(401);

        echo json_encode([
            'erro' => 'Token inválido.'
        ]);

        exit;
    }
}