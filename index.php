
<?php
require_once 'conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="TechStore: hardware, periféricos e tecnologia para elevar o desempenho do seu setup.">
    <title>TechStore | Tecnologia e Performance</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header>
    <a href="index.php" class="marca">
        <span class="logo-simbolo">
            <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M24 3L43 14V34L24 45L5 34V14L24 3Z" stroke="currentColor" stroke-width="3"/>
                <path d="M29 12L17 25H25L19 36L32 21H24L29 12Z" fill="currentColor"/>
            </svg>
        </span>

        <span class="logo-texto">Tech<span>Store</span><small>.</small></span>
    </a>

    <nav>
        <a href="index.php" class="ativo">Início</a>
        <a href="catalogo.php">Produtos</a>
        <a href="login.php">Minha conta</a>
        <a href="carrinho.php">Carrinho</a>
    </nav>
</header>

<main>
    <section class="hero">
        <div class="container">
            <span class="etiqueta">TECNOLOGIA • PERFORMANCE • QUALIDADE</span>

            <h1>
                Seu próximo nível de
                <span>performance</span>
                começa aqui.
            </h1>

            <p>
                Performance, qualidade e tecnologia de verdade.
                Encontre os componentes ideais para levar seu setup
                a outro nível.
            </p>

            <a href="catalogo.php" class="btn">
                Explorar produtos <span>→</span>
            </a>

            <div class="destaques">
                <div>
                    <strong>Hardware</strong>
                    <span>Para seu próximo upgrade</span>
                </div>

                <div>
                    <strong>Seu setup</strong>
                    <span>Do seu jeito, no seu nível</span>
                </div>

                <div>
                    <strong>TechStore</strong>
                    <span>Tecnologia ao seu alcance</span>
                </div>
            </div>
        </div>
    </section>

    <section class="secao container">
        <div class="secao-cabecalho">
            <div>
                <span class="sobretitulo">ENCONTRE O QUE PRECISA</span>
                <h2>Explore a TechStore</h2>
                <p class="subtitulo">
                    Tecnologia selecionada para montar, atualizar e transformar seu setup.
                </p>
            </div>

            <a href="catalogo.php" class="link-ver">
                Ver produtos <span>→</span>
            </a>
        </div>

        <div class="cards">
            <article class="card">
                <div class="icone">▦</div>
                <span class="card-numero">01 / COMPONENTES</span>
                <h3>Hardware</h3>
                <p>
                    Processadores, placas de vídeo e componentes
                    para extrair o máximo desempenho.
                </p>
                <a href="catalogo.php" class="card-link">Explorar categoria →</a>
            </article>

            <article class="card">
                <div class="icone">⌘</div>
                <span class="card-numero">02 / ACESSÓRIOS</span>
                <h3>Periféricos</h3>
                <p>
                    Os acessórios certos para mais precisão,
                    conforto e imersão.
                </p>
                <a href="catalogo.php" class="card-link">Explorar categoria →</a>
            </article>

            <article class="card">
                <div class="icone">ϟ</div>
                <span class="card-numero">03 / DESEMPENHO</span>
                <h3>Performance</h3>
                <p>
                    Encontre a combinação ideal para jogar,
                    trabalhar e criar.
                </p>
                <a href="catalogo.php" class="card-link">Explorar categoria →</a>
            </article>
        </div>
    </section>

    <section class="chamada container">
        <div>
            <span class="sobretitulo">SEU PRÓXIMO UPGRADE COMEÇA AQUI</span>
            <h2>Monte um setup à sua altura.</h2>
            <p>
                Explore nossas categorias e encontre as peças
                ideais para o seu próximo projeto.
            </p>
        </div>

        <a href="catalogo.php" class="btn">Conhecer catálogo →</a>
    </section>
</main>

<footer>
    <a href="index.php" class="marca marca-footer">
        <span class="logo-simbolo">
            <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M24 3L43 14V34L24 45L5 34V14L24 3Z" stroke="currentColor" stroke-width="3"/>
                <path d="M29 12L17 25H25L19 36L32 21H24L29 12Z" fill="currentColor"/>
            </svg>
        </span>

        <span class="logo-texto">Tech<span>Store</span><small>.</small></span>
    </a>

    <p>Tecnologia para ir além.</p>
    <span class="copyright">TechStore © 2026 — Projeto acadêmico.</span>
</footer>

</body>
</html>
