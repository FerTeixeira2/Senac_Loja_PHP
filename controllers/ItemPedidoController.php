<?php
    require_once './models/ItemPedidoModel.php';

    class ItemPedidoController {
        public function getItemPedido() {
            $itemPedidoModel = new ItemPedidoModel();

            $itemPedido = $itemPedidoModel->getItemPedido();

            return json_encode([
                'error' => null,
                'result' => $itemPedido
            ]);
        }

        public function createItemPedido() {
            $dados = json_decode(file_get_contents('php://input'), true);

            if (empty($dados['idPedido']))
                return $this->mostrarErro('BRUXO, INFORMA O idPedido, BLZ');
            if (empty($dados['idProduto']))
                return $this->mostrarErro('BRUXO, INFORMA O idProduto, BLZ');
            if (empty($dados['quantidade']))
                return $this->mostrarErro('BRUXO, INFORMA O quantidade, BLZ');
            $itemPedido = new ItemPedidoModel(
                null,
                $dados['idPedido'],
                $dados['idProduto'],
                $dados['quantidade']
            );

            $itemPedido->create();

            return json_encode([
                'error' => null,
                'result' => true
            ]);
        }

        public function updateItemPedido() {
            $dados = json_decode(file_get_contents('php://input'), true);

            if (empty($dados['idItemPedido']))
            return $this->mostrarErro('BRUXO, INFORMA O idItemPedido, BLZ');
            if (empty($dados['idPedido']))
            return $this->mostrarErro('BRUXO, INFORMA O idPedido, BLZ');
            if (empty($dados['idProduto']))
            return $this->mostrarErro('BRUXO, INFORMA O idProduto, BLZ');
            if (empty($dados['quantidade']))
            return $this->mostrarErro('BRUXO, INFORMA O quantidade, BLZ');

            $itemPedido = new ItemPedidoModel(
                $dados['idItemPedido'],
                $dados['idPedido'],
                $dados['idProduto'],
                $dados['quantidade']
            );

            $itemPedido->update();

            return json_encode([
                'error' => null,
                'result' => true
            ]);
        }

        public function deleteItemPedido() {
            $dados = json_decode(file_get_contents('php://input'), true);

            if(empty($dados['idItemPedido']))
                return $this->mostrarErro('BRUXO, INFORMA O idItemPedido, BLZ');

            $itemPedido = new ItemPedidoModel(
                $dados['idItemPedido'],
            );

            $itemPedido->delete();

            return json_encode([
                'error' => null,
                'result' => true
            ]);   
        }

        private function mostrarErro(string $mensagem) {
            return json_encode([
                'error' => $mensagem,
                'result' => null
            ]);
        }

        public function getValorTotalFromPedidoById() {
            $dados = json_decode(file_get_contents("php://input"),true);

            if(empty($dados['idPedido'])) {
                return $this->mostrarErro('Você deve informar o idPedido');
            }
            $itemPedidoModel = new itemPedidoModel();

            $result = $itemPedidoModel->getValorTotalPedido($dados['idPedido']);

            return json_encode([
                'error' => null,
                'result' => $result
            ]);
        }
    }
?>