<?php

require_once 'conexao.php';
require_once 'dao/ProdutoDAO.php';

$produtoDAO = new ProdutoDAO($pdo);

try {
    $nome = 'Produto Teste Sprint 1';

    $produto = $produtoDAO->inserir(
        1,
        $nome,
        'Produto utilizado para testar o DAO',
        99.90,
        5,
        null,
        true
    );

    echo "<h2>Teste do ProdutoDAO</h2>";

    echo "<h3>1. Inserção</h3>";
    echo "<p>Produto inserido com sucesso.</p>";

    $produtos = $produtoDAO->listar();

    echo "<h3>2. Listagem</h3>";
    echo "<pre>";
    print_r($produtos);
    echo "</pre>";

    $produtoEncontrado = null;

    foreach ($produtos as $item) {
        if ($item['nome'] === $nome) {
            $produtoEncontrado = $item;
            break;
        }
    }

    if ($produtoEncontrado) {
        $id = $produtoEncontrado['id'];

        echo "<h3>3. Busca por ID</h3>";
        echo "<pre>";
        print_r($produtoDAO->buscarPorId($id));
        echo "</pre>";

        $produtoDAO->atualizar(
            $id,
            1,
            'Produto Teste Atualizado',
            'Produto utilizado para testar a atualização',
            119.90,
            8,
            null,
            true
        );

        echo "<h3>4. Atualização</h3>";
        echo "<p>Produto atualizado com sucesso.</p>";

        $produtoDAO->excluir($id);

        echo "<h3>5. Exclusão</h3>";
        echo "<p>Produto de teste excluído com sucesso.</p>";
    } else {
        echo "<p>Não foi possível localizar o produto inserido.</p>";
    }
} catch (Throwable $e) {
    echo "<h3>Erro durante o teste</h3>";
    echo "<pre>";
    echo htmlspecialchars($e->getMessage());
    echo "</pre>";
}