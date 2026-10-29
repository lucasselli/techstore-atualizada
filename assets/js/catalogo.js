
const tabelaProdutos = document.getElementById('lista-produtos');
const mensagem = document.getElementById('mensagem');

async function carregarProdutos() {
    tabelaProdutos.innerHTML = `
        <tr>
            <td colspan="5">Carregando produtos...</td>
        </tr>
    `;

    try {
        const resposta = await fetch('api/catalogo.php');
        const produtos = await resposta.json();

        if (!resposta.ok) {
            throw new Error(produtos.erro || 'Erro ao carregar produtos.');
        }

        if (!Array.isArray(produtos) || produtos.length === 0) {
            tabelaProdutos.innerHTML = `
                <tr>
                    <td colspan="5">Nenhum produto cadastrado.</td>
                </tr>
            `;
            return;
        }

        tabelaProdutos.innerHTML = produtos.map(produto => `
            <tr>
                <td>${escaparHTML(produto.id)}</td>
                <td>${escaparHTML(produto.nome)}</td>
                <td>${formatarPreco(produto.preco)}</td>
                <td>${escaparHTML(produto.quantidade)}</td>
                <td class="acoes-produto">
                    <a class="btn btn-secundario"
                       href="produto-editar.php?id=${encodeURIComponent(produto.id)}">
                        Editar
                    </a>
                    <button type="button"
                            class="btn-excluir"
                            data-id="${escaparHTML(produto.id)}">
                        Excluir
                    </button>
                </td>
            </tr>
        `).join('');

    } catch (erro) {
        tabelaProdutos.innerHTML = `
            <tr>
                <td colspan="5">Não foi possível carregar os produtos.</td>
            </tr>
        `;

        mensagem.textContent = erro.message;
    }
}

tabelaProdutos.addEventListener('click', async evento => {
    const botao = evento.target.closest('.btn-excluir');

    if (!botao) {
        return;
    }

    const id = Number(botao.dataset.id);

    if (!Number.isInteger(id) || id < 1) {
        mensagem.textContent = 'ID do produto inválido.';
        return;
    }

    const confirmar = window.confirm(
        `Tem certeza que deseja excluir o produto ID ${id}? Essa ação não pode ser desfeita.`
    );

    if (!confirmar) {
        return;
    }

    botao.disabled = true;
    mensagem.textContent = 'Excluindo produto...';

    try {
        const resposta = await fetch('api/produtos-acao.php', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id })
        });

        const resultado = await resposta.json();

        if (!resposta.ok) {
            throw new Error(resultado.erro || 'Não foi possível excluir o produto.');
        }

        mensagem.textContent = resultado.mensagem || 'Produto excluído com sucesso!';

        await carregarProdutos();

    } catch (erro) {
        mensagem.textContent = erro.message;
        botao.disabled = false;
    }
});

function formatarPreco(preco) {
    return Number(preco).toLocaleString('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    });
}

function escaparHTML(valor) {
    return String(valor ?? '').replace(/[&<>"']/g, caractere => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#39;'
    })[caractere]);
}

carregarProdutos();
