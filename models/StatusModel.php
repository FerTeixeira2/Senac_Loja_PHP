<?php
    require_once 'DAL/StatusDAO.php';

    class StatusModel {
        public ?int $idStatus;
        public ?string $descricao;

        public function __construct(
            ?int $idStatus = null,
            ?string $descricao = null,
        )
        {
            $this->idStatus = $idStatus;
            $this->descricao = $descricao;
        }

        public function getStatus() {
            $statusDAO = new StatusDAO();

            $status = $statusDAO->getStatus();

            foreach ($status as &$statu) {
                $statu = new StatusModel(
                    $statu['id_status'],
                    $statu['descricao'],
                );
            }

            return $status;
        }
        
        public function create() {
            $statusDAO = new StatusDAO();

            return $statusDAO->createStatus($this);
        }

        public function update() {
            $statusDAO = new StatusDAO();

            return $statusDAO->updateStatus($this);
        }
    }
?>