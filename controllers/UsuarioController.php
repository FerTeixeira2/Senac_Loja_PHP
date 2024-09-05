<?php
    require_once './models/UsuarioModel.php';

    class UsuarioController {
        public function getUsuarios() {
            $usuarioModel = new UsuarioModel();

            $usuarios = $usuarioModel->getUsuarios();

            return json_encode([
                'error' => null,
                'result' => $usuarios
            ]);
        }

        public function createUsuario() {
            $dados = json_decode(file_get_contents('php://input'), true);

            if (empty($dados['nomeUsuario']))
                return $this->mostrarErro('BRUXO, INFORMA O nomeUsuario, BLZ');
            if(empty($dados['cpfUsuario']))
                return $this->mostrarErro('BRUXO, INFORMA O cpfUsuario, BLZ');
            if (empty($dados['senhaUsuario']))
                return $this->mostrarErro('BRUXO, INFORMA O senhaUsuario, BLZ');

            $usuario = new UsuarioModel(
                null,
                $dados['nomeUsuario'],
                $dados['cpfUsuario'],
                md5($dados['senhaUsuario'])
            );

            $validação = $usuario->validarUsuario($dados['cpfUsuario']);

            if ($validação['CPF'] >= 1) {
                return $this->mostrarErro("já existe um usuario com este CPF");
            }

            $usuario->create();

            return json_encode([
                'error' => null,
                'result' => true
            ]);
        }

        public function updateUsuario() {
            $dados = json_decode(file_get_contents('php://input'), true);

            if(empty($dados['idUsuario']))
                return $this->mostrarErro('BRUXO, INFORMA O idUsuario, BLZ');
            if (empty($dados['nomeUsuario']))
                return $this->mostrarErro('BRUXO, INFORMA O nomeUsuario, BLZ');
            if(empty($dados['cpfUsuario']))
                return $this->mostrarErro('BRUXO, INFORMA O emailUsuario, BLZ');
            if (empty($dados['senhaUsuario']))
                return $this->mostrarErro('BRUXO, INFORMA O senhaUsuario, BLZ');

            $usuario = new UsuarioModel(
                $dados['idUsuario'],
                $dados['nomeUsuario'],
                $dados['cpfUsuario'],
                md5($dados['senhaUsuario'])
            );

            $validacao = $usuario->validarUsuario($dados['cpfUsuario']);

            if ($validacao['CPF'] >= 1) {
                return $this->mostrarErro("já existe um usuario com este CPF");
            }

            $usuario->update();

            return json_encode([
                'error' => null,
                'result' => true
            ]);

        }

        public function deleteUsuario() {
            $dados = json_decode(file_get_contents('php://input'), true);

            if(empty($dados['idUsuario']))
                return $this->mostrarErro('BRUXO, INFORMA O idUsuario, BLZ');

            $usuario = new UsuarioModel(
                $dados['idUsuario'],
            );

            $usuario->delete();

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