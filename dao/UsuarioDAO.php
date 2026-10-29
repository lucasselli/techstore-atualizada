<?php

class UsuarioDAO
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function inserir($nome, $email, $senha, $tipo = 'cliente')
    {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuario (nome, email, senha_hash, tipo)
                VALUES (?, ?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $nome,
            $email,
            $senhaHash,
            $tipo
        ]);
    }

    public function listar()
    {
        $sql = "SELECT id, nome, email, tipo, criado_em
                FROM usuario
                ORDER BY nome";

        return $this->pdo->query($sql)->fetchAll();
    }

    public function buscarPorId($id)
    {
        $sql = "SELECT id, nome, email, tipo, criado_em
                FROM usuario
                WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    public function buscarPorEmail($email)
    {
        $sql = "SELECT * FROM usuario WHERE email = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);

        return $stmt->fetch();
    }

    public function atualizar($id, $nome, $email, $tipo)
    {
        $sql = "UPDATE usuario
                SET nome = ?, email = ?, tipo = ?
                WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $nome,
            $email,
            $tipo,
            $id
        ]);
    }

    public function atualizarSenha($id, $senha)
    {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $sql = "UPDATE usuario SET senha_hash = ? WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $senhaHash,
            $id
        ]);
    }

    public function excluir($id)
    {
        $sql = "DELETE FROM usuario WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->rowCount() > 0;
    }
}