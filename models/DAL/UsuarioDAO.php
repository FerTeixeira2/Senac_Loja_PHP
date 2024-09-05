<?php
    require_once 'Conexao.php';

    class UsuarioDAO {
        public function getUsuarios() {
            $conexao = (new conexao())->getConexao();

            $sql = "SELECT * FROM usuario;";

            $stmt = $conexao->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function createUsuario(UsuarioModel $usuario) {
            $conexao = (new conexao())->getConexao();

            $sql = "INSERT INTO usuario VALUES (:id, :nome, :cpf, :senha)";

            $stmt = $conexao->prepare($sql);
            $stmt->bindValue(':id', null);
            $stmt->bindValue(':nome', $usuario->nomeUsuario);
            $stmt->bindValue(':cpf', $usuario->cpfUsuario);
            $stmt->bindValue(':senha', $usuario->senhaUsuario);

            return $stmt->execute();
        }

        public function updateUsuario(UsuarioModel $usuario) {
            $conexao = (new conexao())->getConexao();

            $sql = "UPDATE usuario SET nome = :nome, cpf = :cpf, senha = :senha WHERE id_usuario = :id";

            $stmt = $conexao->prepare($sql);
            $stmt->bindValue(':id', $usuario->idUsuario);
            $stmt->bindValue(':nome', $usuario->nomeUsuario);
            $stmt->bindValue(':cpf', $usuario->cpfUsuario);
            $stmt->bindValue(':senha', $usuario->senhaUsuario);

            return $stmt->execute();
        }

        public function deleteUsuario(UsuarioModel $usuario) {
            $conexao = (new conexao())->getConexao();

            $sql = "DELETE FROM usuario WHERE id_usuario = :id";

            $stmt = $conexao->prepare($sql);
            $stmt->bindValue(':id', $usuario->idUsuario);

            return $stmt->execute();
        }

        public function getCpfUsuario(string $cpf) {
            $conexao = (new conexao)->getConexao();

            $sql = "SELECT count(cpf) as CPF From usuario WHERE cpf = :cpf";
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam("cpf",$cpf);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);

        }
    }
?>