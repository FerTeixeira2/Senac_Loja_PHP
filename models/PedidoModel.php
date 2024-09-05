<?php
    require_once 'DAL/PedidoDAO.php';

    class PedidoModel {
        public ?int $idPedido;
        public ?int $idUsuario;
        public ?int $idStatus;

        public function __construct(
            ?int $idPedido = null,
            ?int $idUsuario = null,
            ?int $idStatus = null
        )
        {
            $this->idPedido = $idPedido;
            $this->idUsuario = $idUsuario;
            $this->idStatus = $idStatus;
        }

        public function getPedido() {
            $pedidoDAO = new PedidoDAO();

            $pedidos = $pedidoDAO->getPedido();

            foreach ($pedidos as &$pedido) {
                $pedido = new PedidoModel(
                    $pedido['id_pedido'],
                    $pedido['id_usuario'],
                    $pedido['id_status']
                );
            }

            return $pedidos;
        }    

        public function create() {
            $pedidoDAO = new PedidoDAO();

            return $pedidoDAO->createPedido($this);
        }

        public function update() {
            $pedidoDAO = new PedidoDAO();

            return $pedidoDAO->updatePedido($this);
        }

        public function delete() {
            $pedidoDAO = new PedidoDAO();

            return $pedidoDAO->deletePedido($this);
        }

        public function getPedidoUsuario($idUsuario){
            $pedidoDAO = new PedidoDAO();

            $pedidos = $pedidoDAO->getPedidoByIdUsuario($idUsuario);

            foreach ($pedidos as &$pedido) {
                $pedido = new PedidoModel(
                    $pedido['id_pedido'],
                    $pedido['id_usuario'],
                    $pedido['id_status'],
                );

            }

            return $pedidos;
        }

        public function updateStatus() {
            $pedidoDAO = new PedidoDAO();

            return $pedidoDAO->updateStatusPedido($this);
        }
    }
?>