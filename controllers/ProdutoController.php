<?php
    require_once './models/ProdutoModel.php';

    class ProdutoController {
        public function getProduto() {
            $produtoModel = new ProdutoModel();

            $produto = $produtoModel->getProduto();

            return json_encode([
                'error' => null,
                'result' => $produto
            ]);
        }

        public function createProduto() {
            $dados = json_decode(file_get_contents('php://input'), true);

            if (empty($dados['descricao']))
                return $this->mostrarErro('BRUXO, INFORMA A descricao, BLZ');
            if (empty($dados['preco']))
                return $this->mostrarErro('BRUXO, INFORMA A preco, BLZ');

            $produto = new ProdutoModel(
                null,
                $dados['descricao'],
                $dados['preco']
            );

            $produto->create();

            return json_encode([
                'error' => null,
                'result' => true
            ]);
        }

        public function updateProduto() {
            $dados = json_decode(file_get_contents('php://input'), true);

            if(empty($dados['idProduto']))
                return $this->mostrarErro('BRUXO, INFORMA O idProduto, BLZ');
            if (empty($dados['descricao']))
                return $this->mostrarErro('BRUXO, INFORMA O descricao, BLZ');
            if (empty($dados['preco']))
                return $this->mostrarErro('BRUXO, INFORMA O preco, BLZ');

            $produto = new ProdutoModel(
                $dados['idProduto'],
                $dados['descricao'],
                $dados['preco']
            );

            $validacao = $produto->validarProduto($dados['descricao']);

            if ($validacao['descricao'] >= 1) {
                return $this->mostrarErro("já existe um produto com esta descricao");
            }

            $produto->update();

            return json_encode([
                'error' => null,
                'result' => true
            ]);
        }

        public function deleteProduto() {
            $dados = json_decode(file_get_contents('php://input'), true);

            if(empty($dados['idProduto']))
                return $this->mostrarErro('BRUXO, INFORMA O idProduto, BLZ');

            $produto = new ProdutoModel(
                $dados['idProduto'],
            );

            $produto->delete();

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