<?php
    require_once 'Conexao.php';

    class ItemPedidoDAO {
        public function getItemPedido() {
            $conexao = (new conexao())->getConexao();

            $sql = "SELECT * FROM item_pedido;";

            $stmt = $conexao->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function createItemPedido(ItemPedidoModel $itemPedido) {
            $conexao = (new conexao())->getConexao();

            $sql = "INSERT INTO item_pedido VALUES (:id, :idPedido, :idProduto, :quantidade)";

            $stmt = $conexao->prepare($sql);
            $stmt->bindValue(':id', null);
            $stmt->bindValue(':idPedido', $itemPedido->idPedido);
            $stmt->bindValue(':idProduto', $itemPedido->idProduto);
            $stmt->bindValue(':quantidade', $itemPedido->quantidade);

            return $stmt->execute();
        }

        public function updateItemPedido(ItemPedidoModel $itemPedido) {
            $conexao = (new conexao())->getConexao();

            $sql = "UPDATE item_pedido SET id_pedido = :idPedido, id_produto = :idProduto, quantidade = :quantidade WHERE id_item_pedido = :idItemPedido";

            $stmt = $conexao->prepare($sql);
            $stmt->bindValue(':idItemPedido', $itemPedido->idItemPedido);
            $stmt->bindValue(':idPedido', $itemPedido->idPedido);
            $stmt->bindValue(':idProduto', $itemPedido->idProduto);
            $stmt->bindValue(':quantidade', $itemPedido->quantidade);

            return $stmt->execute();
        }

        public function deleteItemPedido(ItemPedidoModel $itemPedido) {
            $conexao = (new conexao())->getConexao();

            $sql = "DELETE FROM item_pedido WHERE id_item_pedido = :id";

            $stmt = $conexao->prepare($sql);
            $stmt->bindValue(':id', $itemPedido->idItemPedido);

            return $stmt->execute();
        }

        public function getValorTotalFromPedidoById($idPedido) {
            $conexao = (new conexao)->getConexao();

            $sql = "SELECT ip.*,ip.quantidade * p.precoProduto as valorTotal from item_pedido ip left join produto p on ip.idProduto = p.idProduto where ip.idPedido = :id";

            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(":id",$idPedido);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>