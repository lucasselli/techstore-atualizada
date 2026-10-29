
<?php

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../conexao.php';
require_once __DIR__ . '/autenticacao.php';

try {
    verificarToken();

    $stmt = $pdo->query(
        'SELECT id, nome FROM categoria ORDER BY nome'
    );

    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

    http_response_code(200);
    echo json_encode($categorias, JSON_UNESCAPED_UNICODE);

} catch (Throwable $e) {
    error_log($e->getMessage());

    http_response_code(500);
    echo json_encode([
        'erro' => 'Não foi possível carregar as categorias.'
    ], JSON_UNESCAPED_UNICODE);
}
