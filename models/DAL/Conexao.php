<?php
    class conexao {
        private PDO $conexao;

        public function __construct() {
            $this->conexao = new PDO('mysql:host=localhost;dbname=trabalhophp', 'root', '');
        }
        public function getConexao(): PDO {
            return $this->conexao;
        }
    }
?>