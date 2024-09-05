<?php
    require_once './models/StatusModel.php';

    class StatusController {
        public function getStatus() {
            $statusModel = new StatusModel();

            $status = $statusModel->getStatus();

            return json_encode([
                'error' => null,
                'result' => $status
            ]);
        }

        public function createStatus() {
            $dados = json_decode(file_get_contents('php://input'), true);

            if (empty($dados['descricao']))
                return $this->mostrarErro('BRUXO, INFORMA A descricao, BLZ');

            $status = new StatusModel(
                null,
                $dados['descricao'],
            );

            $status->create();

            return json_encode([
                'error' => null,
                'result' => true
            ]);
        }

        public function updateStatus() {
            $dados = json_decode(file_get_contents('php://input'), true);

            if(empty($dados['idStatus']))
                return $this->mostrarErro('BRUXO, INFORMA O idStatu, BLZ');
            if (empty($dados['descricao']))
                return $this->mostrarErro('BRUXO, INFORMA O descricao, BLZ');

            $status = new StatusModel(
                $dados['idUsuario'],
                $dados['descricao'],
            );

            $status->update();

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
    }
?>