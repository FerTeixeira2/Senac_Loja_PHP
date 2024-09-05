<?php
    require_once 'DAL/UsuarioDAO.php';

    class UsuarioModel {
        public ?int $idUsuario;
        public ?string $nomeUsuario;
        public ?string $cpfUsuario;
        public ?string $senhaUsuario;

        public function __construct(
            ?int $idUsuario = null,
            ?string $nomeUsuario = null,
            ?string $cpfUsuario = null,
            ?string $senhaUsuario = null
        )
        {
            $this->idUsuario = $idUsuario;
            $this->nomeUsuario = $nomeUsuario;
            $this->cpfUsuario = $cpfUsuario;
            $this->senhaUsuario = $senhaUsuario;
        }

        public function getUsuarios() {
            $usuarioDAO = new UsuarioDAO();

            $usuarios = $usuarioDAO->getUsuarios();

            foreach ($usuarios as &$usuario) {
                $usuario = new UsuarioModel(
                    $usuario['id_usuario'],
                    $usuario['nome'],
                    $usuario['cpf'],
                    $usuario['senha']
                );
            }

            return $usuarios;
        }

        public function create() {
            $usuarioDAO = new UsuarioDAO();

            return $usuarioDAO->createUsuario($this);
        }

        public function update() {
            $usuarioDAO = new UsuarioDAO();

            return $usuarioDAO->updateUsuario($this);
        }

        public function delete() {
            $usuarioDAO = new UsuarioDAO();

            return $usuarioDAO->deleteUsuario($this);
        }

        public function validarUsuario(string $cpf) {
            $usuarioDAO = new UsuarioDAO();

            return $usuarioDAO->getCpfUsuario($cpf);
        }
    }
?>