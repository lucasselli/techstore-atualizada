
<?php
require_once 'conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos | TechStore</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header>
    <a href="index.php" class="marca">
        <span class="logo-simbolo">T</span>
        <span class="logo-texto">Tech<span>Store</span><small>.</small></span>
    </a>

    <nav>
        <a href="index.php">Início</a>
        <a href="catalogo.php" class="ativo">Produtos</a>
        <a href="login.php">Minha conta</a>
        <a href="carrinho.php">Carrinho</a>
    </nav>
</header>

<main class="container secao">
    <div class="secao-cabecalho">
        <div>
            <span class="sobretitulo">TECHSTORE</span>
            <h1>Catálogo de produtos</h1>
            <p class="subtitulo">Consulte e gerencie os produtos da loja.</p>
        </div>

        <a href="produto-novo.php" class="btn">Cadastrar produto +</a>
    </div>

    <p id="mensagem" role="status"></p>

    <div class="tabela-container">
        <table class="tabela-produtos">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Produto</th>
                    <th>Preço</th>
                    <th>Quantidade</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="lista-produtos">
                <tr>
                    <td colspan="5">Aguardando conexão com a API...</td>
                </tr>
            </tbody>
        </table>
    </div>
</main>

<footer>
    <a href="index.php" class="marca marca-footer">
        <span class="logo-simbolo">T</span>
        <span class="logo-texto">Tech<span>Store</span><small>.</small></span>
    </a>

    <p>Tecnologia para ir além.</p>
    <span class="copyright">TechStore © 2026 — Projeto acadêmico.</span>
</footer>
<script src="assets/js/catalogo.js"></script>
</body>
</html>
