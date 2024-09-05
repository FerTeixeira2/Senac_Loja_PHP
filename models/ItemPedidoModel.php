<?php
    require_once 'DAL/ItemPedidoDAO.php';

    class ItemPedidoModel {
        public ?int $idItemPedido;
        public ?int $idPedido;
        public ?int $idProduto;
        public ?string $quantidade;

        public function __construct(
            ?int $idItemPedido = null,
            ?int $idPedido = null,
            ?int $idProduto = null,
            ?string $quantidade = null
        )
        {
            $this->idItemPedido = $idItemPedido;
            $this->idPedido = $idPedido;
            $this->idProduto = $idProduto;
            $this->quantidade = $quantidade;
        }

        public function getItemPedido() {
            $itemPedidoDAO = new ItemPedidoDAO();

            $itemPedidos = $itemPedidoDAO->getItemPedido();

            foreach ($itemPedidos as &$itemPedido) {
                $itemPedido = new ItemPedidoModel(
                    $itemPedido['id_item_pedido'],
                    $itemPedido['id_pedido'],
                    $itemPedido['id_produto'],
                    $itemPedido['quantidade']
                );
            }

            return $itemPedidos;
        }    

        public function create() {
            $itemPedidoDAO = new ItemPedidoDAO();

            return $itemPedidoDAO->createItemPedido($this);
        }

        public function update() {
            $itemPedidoDAO = new ItemPedidoDAO();

            return $itemPedidoDAO->updateItemPedido($this);
        }

        public function delete() {
            $itemPedidoDAO = new ItemPedidoDAO();

            return $itemPedidoDAO->deleteItemPedido($this);
        }

        public function getValorTotalPedido($idPedido) {
            $ItemPedidoDAO = new ItemPedidoDAO;

            return $ItemPedidoDAO->getValorTotalFromPedidoById($idPedido);

            
            foreach ($itens as &$item) {
                $item = new itemPedidoModel(
                    $item['id_item_pedido'],
                    $item['idProduto'],
                    $item['idPedido'],
                    $item['quantidade'],
                    $item['valorTotal']
                );
            }
            return $itens;
        }
    }
?>