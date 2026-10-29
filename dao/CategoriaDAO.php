
<?php

class CategoriaDAO
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function inserir($nome, $descricao)
    {
        $sql = "INSERT INTO categoria (nome, descricao) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nome, $descricao]);
    }

    public function listar()
    {
        $sql = "SELECT * FROM categoria ORDER BY nome";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function buscarPorId($id)
    {
        $sql = "SELECT * FROM categoria WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function atualizar($id, $nome, $descricao)
    {
        $sql = "UPDATE categoria SET nome = ?, descricao = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nome, $descricao, $id]);
    }

    public function excluir($id)
    {
        $sql = "DELETE FROM categoria WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}
