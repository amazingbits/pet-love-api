<?php

namespace App\Model\BloqueioDAO;

use App\Core\Connection;
use App\Model\BaseDAO\BaseDAO;

class BloqueioDAO extends BaseDAO implements iBloqueioDAO
{
    public function __construct()
    {
        $this->setTable("bloqueio");
    }

    public function verificarSeHaBloqueioNaDataEspecificada(int $idAgenda, string $data): bool
    {
        $sqlQuery = "SELECT * 
                     FROM bloqueio 
                     WHERE agenda = :agenda 
                     AND ( :data BETWEEN data_inicial AND data_final )";
        try {
            $conn = Connection::getInstance();
            $stmt = $conn->prepare($sqlQuery);
            $stmt->bindValue(":agenda", $idAgenda);
            $stmt->bindValue(":data", $data);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (\PDOException $e) {
            return false;
        }
    }
}