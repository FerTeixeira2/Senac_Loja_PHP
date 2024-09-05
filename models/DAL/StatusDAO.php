<?php
    require_once 'Conexao.php';

    class StatusDAO {
        public function getStatus() {
            $conexao = (new conexao())->getConexao();

            $sql = "SELECT * FROM statu";

            $stmt = $conexao->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function createStatus(StatusModel $status) {
            $conexao = (new conexao())->getConexao();

            $sql = "INSERT INTO statu VALUES (:id, :descricao)";

            $stmt = $conexao->prepare($sql);
            $stmt->bindValue(':id', null);
            $stmt->bindValue(':descricao', $status->descricao);

            return $stmt->execute();
        }

        public function updateStatus(StatusModel $status) {
            $conexao = (new conexao())->getConexao();

            $sql = "UPDATE statu SET descricao = :descricao WHERE idStatus = :id";

            $stmt = $conexao->prepare($sql);
            $stmt->bindValue(':id', $status->idStatus);
            $stmt->bindValue(':descricao', $status->descricao);

            return $stmt->execute();
        }
    }
?>