
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar produto | TechStore</title>
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
            <span class="sobretitulo">GERENCIAMENTO</span>
            <h1>Editar produto</h1>
            <p class="subtitulo">Altere os dados do produto cadastrado.</p>
        </div>
    </div>

    <p id="mensagem" role="status">Carregando produto...</p>

    <form id="form-editar-produto" class="form-produto" hidden>
        <label for="categoria_id">Categoria</label>
        <select id="categoria_id" name="categoria_id" required>
            <option value="">Selecione uma categoria</option>
        </select>

        <label for="nome">Nome do produto</label>
        <input type="text" id="nome" name="nome" maxlength="120" required>

        <label for="descricao">Descrição</label>
        <textarea id="descricao" name="descricao" maxlength="255"></textarea>

        <label for="preco">Preço (R$)</label>
        <input type="number" id="preco" name="preco" min="0" step="0.01" required>

        <label for="quantidade">Quantidade em estoque</label>
        <input type="number" id="quantidade" name="quantidade" min="0" step="1" required>

        <label for="imagem">Caminho da imagem (opcional)</label>
        <input type="text" id="imagem" name="imagem" maxlength="255">

        <button type="submit" class="btn">Salvar alterações</button>
        <a href="catalogo.php" class="btn btn-secundario">Cancelar</a>
    </form>
</main>

<footer>
    <a href="index.php" class="marca marca-footer">
        <span class="logo-simbolo">T</span>
        <span class="logo-texto">Tech<span>Store</span><small>.</small></span>
    </a>
    <p>Tecnologia para ir além.</p>
    <span class="copyright">TechStore © 2026 — Projeto acadêmico.</span>
</footer>

<script src="assets/js/produto-editar.js"></script>
</body>
</html>
