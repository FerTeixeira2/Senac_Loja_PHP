<?php
    require_once 'Conexao.php';

    class ProdutoDAO {
        public function getProduto() {
            $conexao = (new conexao())->getConexao();

            $sql = "SELECT * FROM produto;";

            $stmt = $conexao->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function createProduto(ProdutoModel $produto) {
            $conexao = (new conexao())->getConexao();

            $sql = "INSERT INTO produto VALUES (:id, :descricao, :preco)";

            $stmt = $conexao->prepare($sql);
            $stmt->bindValue(':id', null);
            $stmt->bindValue(':descricao', $produto->descricao);
            $stmt->bindValue(':preco', $produto->preco);

            return $stmt->execute();
        }

        public function updateProduto(ProdutoModel $produto) {
            $conexao = (new conexao())->getConexao();

            $sql = "UPDATE produto SET descricao = :descricao, preco = :preco WHERE id_produto = :id";

            $stmt = $conexao->prepare($sql);
            $stmt->bindValue(':id', $produto->idProduto);
            $stmt->bindValue(':descricao', $produto->descricao);
            $stmt->bindValue(':preco', $produto->preco);

            return $stmt->execute();
        }

        public function deleteProduto(ProdutoModel $produto) {
            $conexao = (new conexao())->getConexao();

            $sql = "DELETE FROM produto WHERE id_produto = :id";

            $stmt = $conexao->prepare($sql);
            $stmt->bindValue(':id', $produto->idProduto);

            return $stmt->execute();
        }

        public function getNomeProduto(string $descricao) {
            $conexao = (new conexao)->getConexao();

            $sql = "SELECT count(descricao) as descricao From produto WHERE descricao = :descricao";
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam("descricao",$descricao);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);

        }
    }
?>