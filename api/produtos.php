
<?php

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../conexao.php';
require_once __DIR__ . '/../dao/ProdutoDAO.php';
require_once __DIR__ . '/autenticacao.php';

function responder($codigo, $dados)
{
    http_response_code($codigo);
    echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    exit;
}

function lerDados()
{
    $dados = json_decode(file_get_contents('php://input'), true);

    if (!is_array($dados)) {
        responder(400, ['erro' => 'Envie um JSON válido.']);
    }

    return $dados;
}

function validarProduto($dados)
{
    if (
        empty($dados['categoria_id']) ||
        !filter_var($dados['categoria_id'], FILTER_VALIDATE_INT) ||
        $dados['categoria_id'] < 1 ||
        !isset($dados['nome']) ||
        trim($dados['nome']) === '' ||
        !isset($dados['preco']) ||
        !is_numeric($dados['preco']) ||
        $dados['preco'] < 0 ||
        !isset($dados['quantidade']) ||
        filter_var($dados['quantidade'], FILTER_VALIDATE_INT) === false ||
        $dados['quantidade'] < 0
    ) {
        responder(400, [
            'erro' => 'Informe categoria, nome, preço e quantidade válidos.'
        ]);
    }

    if (strlen(trim($dados['nome'])) > 120) {
        responder(400, ['erro' => 'O nome deve ter até 120 caracteres.']);
    }

    if (isset($dados['descricao']) && strlen($dados['descricao']) > 255) {
        responder(400, ['erro' => 'A descrição deve ter até 255 caracteres.']);
    }

    if (isset($dados['imagem']) && strlen($dados['imagem']) > 255) {
        responder(400, ['erro' => 'O campo imagem deve ter até 255 caracteres.']);
    }
}

try {
    verificarToken();

    $produtoDAO = new ProdutoDAO($pdo);
    $metodo = $_SERVER['REQUEST_METHOD'];

    if ($metodo === 'GET') {
        if (isset($_GET['id'])) {
            $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

            if (!$id || $id < 1) {
                responder(400, ['erro' => 'ID inválido.']);
            }

            $produto = $produtoDAO->buscarPorId($id);

            if (!$produto) {
                responder(404, ['erro' => 'Produto não encontrado.']);
            }

            responder(200, $produto);
        }

        responder(200, $produtoDAO->listar());
    }

    if ($metodo === 'POST') {
        $dados = lerDados();
        validarProduto($dados);

        $stmt = $pdo->prepare('SELECT id FROM categoria WHERE id = ?');
        $stmt->execute([$dados['categoria_id']]);

        if (!$stmt->fetch()) {
            responder(400, ['erro' => 'A categoria informada não existe.']);
        }

        $nome = trim($dados['nome']);
        $descricao = $dados['descricao'] ?? null;
        $imagem = $dados['imagem'] ?? null;
        $ativo = isset($dados['ativo']) ? (int) (bool) $dados['ativo'] : 1;

        $produtoDAO->inserir(
            (int) $dados['categoria_id'],
            $nome,
            $descricao,
            (float) $dados['preco'],
            (int) $dados['quantidade'],
            $imagem,
            $ativo
        );

        responder(201, ['mensagem' => 'Produto cadastrado com sucesso.']);
    }

    if ($metodo === 'PUT') {
        if (!isset($_GET['id'])) {
            responder(400, ['erro' => 'Informe o ID do produto.']);
        }

        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

        if (!$id || $id < 1) {
            responder(400, ['erro' => 'ID inválido.']);
        }

        if (!$produtoDAO->buscarPorId($id)) {
            responder(404, ['erro' => 'Produto não encontrado.']);
        }

        $dados = lerDados();
        validarProduto($dados);

        $stmt = $pdo->prepare('SELECT id FROM categoria WHERE id = ?');
        $stmt->execute([$dados['categoria_id']]);

        if (!$stmt->fetch()) {
            responder(400, ['erro' => 'A categoria informada não existe.']);
        }

        $produtoDAO->atualizar(
            $id,
            (int) $dados['categoria_id'],
            trim($dados['nome']),
            $dados['descricao'] ?? null,
            (float) $dados['preco'],
            (int) $dados['quantidade'],
            $dados['imagem'] ?? null,
            isset($dados['ativo']) ? (int) (bool) $dados['ativo'] : 1
        );

        responder(200, ['mensagem' => 'Produto atualizado com sucesso.']);
    }

    if ($metodo === 'DELETE') {
        if (!isset($_GET['id'])) {
            responder(400, ['erro' => 'Informe o ID do produto.']);
        }

        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

        if (!$id || $id < 1) {
            responder(400, ['erro' => 'ID inválido.']);
        }

        if (!$produtoDAO->buscarPorId($id)) {
            responder(404, ['erro' => 'Produto não encontrado.']);
        }

        $produtoDAO->excluir($id);

        responder(200, ['mensagem' => 'Produto excluído com sucesso.']);
    }

    header('Allow: GET, POST, PUT, DELETE');
    responder(405, ['erro' => 'Método não permitido.']);

} catch (PDOException $e) {
    error_log($e->getMessage());

    if (
        $e->getCode() === '23000' &&
        str_contains($e->getMessage(), '1451')
    ) {
        responder(409, [
            'erro' => 'Este produto está vinculado a um ou mais pedidos e não pode ser excluído.'
        ]);
    }

    responder(400, [
        'erro' => 'Não foi possível concluir a operação no banco de dados.'
    ]);
} catch (Throwable $e) {
    error_log($e->getMessage());
    responder(500, ['erro' => 'Ocorreu um erro interno.']);
}
