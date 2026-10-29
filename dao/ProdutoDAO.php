<?php

class ProdutoDAO
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function inserir($categoria_id, $nome, $descricao, $preco, $quantidade, $imagem, $ativo)
    {
        $sql = "INSERT INTO produto (categoria_id, nome, descricao, preco, quantidade, imagem, ativo)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $categoria_id,
            $nome,
            $descricao,
            $preco,
            $quantidade,
            $imagem,
            $ativo
        ]);
    }

    public function listar()
    {
        $sql = "SELECT produto.*, categoria.nome AS categoria_nome
                FROM produto
                INNER JOIN categoria ON produto.categoria_id = categoria.id
                ORDER BY produto.nome";

        return $this->pdo->query($sql)->fetchAll();
    }

    public function buscarPorId($id)
    {
        $sql = "SELECT * FROM produto WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    public function atualizar($id, $categoria_id, $nome, $descricao, $preco, $quantidade, $imagem, $ativo)
    {
        $sql = "UPDATE produto
                SET categoria_id = ?, nome = ?, descricao = ?, preco = ?,
                    quantidade = ?, imagem = ?, ativo = ?
                WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $categoria_id,
            $nome,
            $descricao,
            $preco,
            $quantidade,
            $imagem,
            $ativo,
            $id
        ]);
    }

    public function excluir($id)
{
    $sql = "DELETE FROM produto WHERE id = ?";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$id]);

    return $stmt->rowCount() > 0;
}
}