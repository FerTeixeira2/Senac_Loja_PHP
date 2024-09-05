<?php
    require_once 'DAL/ProdutoDAO.php';

    class ProdutoModel {
        public ?int $idProduto;
        public ?string $descricao;
        public ?string $preco;

        public function __construct(
            ?int $idProduto = null,
            ?string $descricao = null,
            ?string $preco = null,
        )
        {
            $this->idProduto = $idProduto;
            $this->descricao = $descricao;
            $this->preco = $preco;
        }

        public function getProduto() {
            $produtoDAO = new ProdutoDAO();

            $produtos = $produtoDAO->getProduto();

            foreach ($produtos as &$produto) {
                $produto = new ProdutoModel(
                    $produto['id_produto'],
                    $produto['descricao'],
                    $produto['preco']
                );
            }

            return $produtos;
        }
        
        public function create() {
            $produtoDAO = new ProdutoDAO();

            return $produtoDAO->createProduto($this);
        }

        public function update() {
            $produtoDAO = new ProdutoDAO();

            return $produtoDAO->updateProduto($this);
        }

        public function delete() {
            $produtoDAO = new ProdutoDAO();

            return $produtoDAO->deleteProduto($this);
        }

        public function validarProduto(string $descricao) {
            $produtoDAO = new ProdutoDAO();

            return $produtoDAO->getNomeProduto($descricao);
        }
    }
?>