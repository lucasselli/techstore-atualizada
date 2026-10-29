<?php

class ClienteDAO
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function inserir($usuario_id, $telefone)
    {
        $sql = "INSERT INTO cliente (usuario_id, telefone)
                VALUES (?, ?)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $usuario_id,
            $telefone
        ]);
    }

    public function listar()
    {
        $sql = "SELECT cliente.*, usuario.nome, usuario.email
                FROM cliente
                INNER JOIN usuario ON cliente.usuario_id = usuario.id
                ORDER BY usuario.nome";

        return $this->pdo->query($sql)->fetchAll();
    }

    public function buscarPorId($id)
    {
        $sql = "SELECT cliente.*, usuario.nome, usuario.email
                FROM cliente
                INNER JOIN usuario ON cliente.usuario_id = usuario.id
                WHERE cliente.id = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    public function buscarPorUsuarioId($usuario_id)
    {
        $sql = "SELECT * FROM cliente WHERE usuario_id = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$usuario_id]);

        return $stmt->fetch();
    }

    public function atualizar($id, $telefone)
    {
        $sql = "UPDATE cliente
                SET telefone = ?
                WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $telefone,
            $id
        ]);
    }

    public function excluir($id)
    {
        $sql = "DELETE FROM cliente WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->rowCount() > 0;
    }
}