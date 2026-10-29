
const formulario = document.getElementById('form-editar-produto');
const mensagem = document.getElementById('mensagem');
const campoCategoria = document.getElementById('categoria_id');
const parametros = new URLSearchParams(window.location.search);
const id = Number(parametros.get('id'));

async function carregarProduto() {
    if (!Number.isInteger(id) || id < 1) {
        mensagem.textContent = 'ID do produto inválido.';
        return;
    }

    try {
        const [respostaProduto, respostaCategorias] = await Promise.all([
            fetch(`api/catalogo.php?id=${id}`),
            fetch('api/categorias-publico.php')
        ]);

        const produto = await respostaProduto.json();

        if (!respostaProduto.ok) {
            throw new Error(produto.erro || 'Não foi possível carregar o produto.');
        }

        const categorias = await respostaCategorias.json();

        if (!respostaCategorias.ok || !Array.isArray(categorias)) {
            throw new Error('Não foi possível carregar as categorias.');
        }

        campoCategoria.innerHTML = '<option value="">Selecione uma categoria</option>';

        categorias.forEach(categoria => {
            const opcao = document.createElement('option');
            opcao.value = categoria.id;
            opcao.textContent = categoria.nome;
            campoCategoria.appendChild(opcao);
        });

        campoCategoria.value = produto.categoria_id ?? '';
        formulario.nome.value = produto.nome ?? '';
        formulario.descricao.value = produto.descricao ?? '';
        formulario.preco.value = produto.preco ?? '';
        formulario.quantidade.value = produto.quantidade ?? '';
        formulario.imagem.value = produto.imagem ?? '';

        formulario.hidden = false;
        mensagem.textContent = 'Produto carregado. Faça as alterações necessárias.';

    } catch (erro) {
        mensagem.textContent = erro.message;
    }
}

formulario.addEventListener('submit', async evento => {
    evento.preventDefault();

    const botao = formulario.querySelector('button[type="submit"]');
    botao.disabled = true;
    mensagem.textContent = 'Salvando alterações...';

    const produto = {
        categoria_id: Number(formulario.categoria_id.value),
        nome: formulario.nome.value.trim(),
        descricao: formulario.descricao.value.trim(),
        preco: Number(formulario.preco.value),
        quantidade: Number(formulario.quantidade.value),
        imagem: formulario.imagem.value.trim() || null,
        ativo: 1
    };

    try {
        const resposta = await fetch('api/produtos-acao.php', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id, produto })
        });

        const resultado = await resposta.json();

        if (!resposta.ok) {
            throw new Error(resultado.erro || 'Não foi possível atualizar o produto.');
        }

        mensagem.textContent = resultado.mensagem || 'Produto atualizado com sucesso!';

    } catch (erro) {
        mensagem.textContent = erro.message;
    } finally {
        botao.disabled = false;
    }
});

carregarProduto();
