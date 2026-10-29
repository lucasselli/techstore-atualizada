<?php

class ItemPedidoDAO
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function inserir($pedido_id, $produto_id, $quantidade, $preco_unitario)
    {
        $sql = "INSERT INTO item_pedido
                (pedido_id, produto_id, quantidade, preco_unitario)
                VALUES (?, ?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $pedido_id,
            $produto_id,
            $quantidade,
            $preco_unitario
        ]);
    }

    public function listar()
    {
        $sql = "SELECT item_pedido.*,
                       produto.nome AS produto_nome
                FROM item_pedido
                INNER JOIN produto
                    ON item_pedido.produto_id = produto.id
                ORDER BY item_pedido.id";

        return $this->pdo->query($sql)->fetchAll();
    }

    public function buscarPorId($id)
    {
        $sql = "SELECT item_pedido.*,
                       produto.nome AS produto_nome
                FROM item_pedido
                INNER JOIN produto
                    ON item_pedido.produto_id = produto.id
                WHERE item_pedido.id = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    public function buscarPorPedido($pedido_id)
    {
        $sql = "SELECT item_pedido.*,
                       produto.nome AS produto_nome
                FROM item_pedido
                INNER JOIN produto
                    ON item_pedido.produto_id = produto.id
                WHERE item_pedido.pedido_id = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$pedido_id]);

        return $stmt->fetchAll();
    }

    public function atualizar($id, $produto_id, $quantidade, $preco_unitario)
    {
        $sql = "UPDATE item_pedido
                SET produto_id = ?,
                    quantidade = ?,
                    preco_unitario = ?
                WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $produto_id,
            $quantidade,
            $preco_unitario,
            $id
        ]);
    }

    public function excluir($id)
    {
        $sql = "DELETE FROM item_pedido WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->rowCount() > 0;
    }
}