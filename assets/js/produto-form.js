
const formulario = document.getElementById('form-produto');
const mensagem = document.getElementById('mensagem');

formulario.addEventListener('submit', async function (evento) {
    evento.preventDefault();

    const botao = formulario.querySelector('button[type="submit"]');
    botao.disabled = true;
    mensagem.textContent = 'Salvando produto...';

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
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                produto: produto
            })
        });

        const resultado = await resposta.json();

        if (!resposta.ok) {
            throw new Error(resultado.erro || 'Não foi possível salvar o produto.');
        }

        mensagem.textContent = resultado.mensagem || 'Produto cadastrado com sucesso!';
        formulario.reset();

    } catch (erro) {
        mensagem.textContent = erro.message || 'Erro ao comunicar com o servidor.';
    } finally {
        botao.disabled = false;
    }
});
