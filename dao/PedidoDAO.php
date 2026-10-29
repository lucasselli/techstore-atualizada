<?php

class PedidoDAO
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function inserir($cliente_id, $valor_total, $status = 'pendente')
    {
        $sql = "INSERT INTO pedido (cliente_id, valor_total, status)
                VALUES (?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $cliente_id,
            $valor_total,
            $status
        ]);
    }

    public function listar()
    {
        $sql = "SELECT pedido.*, usuario.nome AS cliente_nome
                FROM pedido
                INNER JOIN cliente ON pedido.cliente_id = cliente.id
                INNER JOIN usuario ON cliente.usuario_id = usuario.id
                ORDER BY pedido.data_pedido DESC";

        return $this->pdo->query($sql)->fetchAll();
    }

    public function buscarPorId($id)
    {
        $sql = "SELECT pedido.*, usuario.nome AS cliente_nome
                FROM pedido
                INNER JOIN cliente ON pedido.cliente_id = cliente.id
                INNER JOIN usuario ON cliente.usuario_id = usuario.id
                WHERE pedido.id = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    public function buscarPorCliente($cliente_id)
    {
        $sql = "SELECT * FROM pedido
                WHERE cliente_id = ?
                ORDER BY data_pedido DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$cliente_id]);

        return $stmt->fetchAll();
    }

    public function atualizar($id, $valor_total, $status)
    {
        $sql = "UPDATE pedido
                SET valor_total = ?, status = ?
                WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $valor_total,
            $status,
            $id
        ]);
    }

    public function excluir($id)
    {
        $sql = "DELETE FROM pedido WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->rowCount() > 0;
    }
}