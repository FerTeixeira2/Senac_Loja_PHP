<?php
    require_once './models/PedidoModel.php';

    class PedidoController {
        public function getPedido() {
            $pedidoModel = new PedidoModel();

            $pedido = $pedidoModel->getPedido();

            return json_encode([
                'error' => null,
                'result' => $pedido
            ]);
        }

        public function createPedido() {
            $dados = json_decode(file_get_contents('php://input'), true);

            if (empty($dados['idUsuario']))
                return $this->mostrarErro('BRUXO, INFORMA O idUsuario, BLZ');
            if (empty($dados['idStatus']))
                return $this->mostrarErro('BRUXO, INFORMA O idStatus, BLZ');

            $pedido = new PedidoModel(
                null,
                $dados['idUsuario'],
                $dados['idStatus']
            );

            $pedido->create();

            return json_encode([
                'error' => null,
                'result' => true
            ]);
        }

        public function updatePedido() {
            $dados = json_decode(file_get_contents('php://input'), true);

            if(empty($dados['idPedido']))
                return $this->mostrarErro('BRUXO, INFORMA O idPedido, BLZ');
            if (empty($dados['idUsuario']))
                return $this->mostrarErro('BRUXO, INFORMA O idUsuario, BLZ');
            if (empty($dados['idStatus']))
                return $this->mostrarErro('BRUXO, INFORMA O idStatus, BLZ');

            $pedido = new PedidoModel(
                $dados['idPedido'],
                $dados['idUsuario'],
                $dados['idStatus']
            );

            $pedido->update();

            return json_encode([
                'error' => null,
                'result' => true
            ]);
        }

        public function deletePedido() {
            $dados = json_decode(file_get_contents('php://input'), true);

            if(empty($dados['idPedido']))
                return $this->mostrarErro('BRUXO, INFORMA O idPedido, BLZ');

            $pedido = new PedidoModel(
                $dados['idPedido'],
            );

            $pedido->delete();

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

        public function getPedidoPessoa(){
            $dados = json_decode(file_get_contents("php://input"),true);

            if(empty($dados['idUsuario'])) {
                return $this->mostrarErro('Você deve informar o idUsuario');
            }
            $pedidoModel = new PedidoModel();

            $result = $pedidoModel->getPedidoUsuario($dados['idUsuario']);

            return json_encode([
                'error' => null,
                'result' => $result
            ]);
        }

        public function updateStatusPedido() {
            $dados = json_decode(file_get_contents('php://input'),true);

            if(empty($dados['idPedido'])) {
                return $this->mostrarErro('Você deve informar o idPedido');
            }
            if(empty($dados['idStatus'])){
                return $this->mostrarErro('Você deve mostar o idUsuario');
            }

            $usuario = new PedidoModel (
                $dados['idPedido'],
                null,
                $dados['idStatus']
            );

            $usuario->updateStatus();

            return json_encode([
                'error' => null,
                'result' => true
            ]);

        }
    }
?>