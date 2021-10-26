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

    public function carregarMeusBloqueios(int $idUser): array
    {
        $sqlQuery = "SELECT * FROM bloqueio WHERE usuario = :idUser";
        try {
            $conn = Connection::getInstance();
            $stmt = $conn->prepare($sqlQuery);
            $stmt->bindValue(":idUser", $idUser);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function selectById(int $id): array
    {
        $sqlQuery = "
            SELECT bloqueio.id AS id,
                   bloqueio.descricao AS descricao,
                   DATE_FORMAT(bloqueio.data_inicial, '%d/%m/%Y') AS data_inicial,
                   DATE_FORMAT(bloqueio.data_final, '%d/%m/%Y') AS data_final,
                   bloqueio.usuario AS usuario,
                   bloqueio.agenda AS agenda,
                   agenda.descricao AS descAgenda,
                   usuario.nome AS descUsuario
            FROM bloqueio
            INNER JOIN agenda ON (bloqueio.agenda = agenda.id)  
            INNER JOIN usuario ON (bloqueio.usuario = usuario.id)
            WHERE bloqueio.id = :id
        ";
        try {
            $conn = Connection::getInstance();
            $stmt = $conn->prepare($sqlQuery);
            $stmt->bindValue(":id", $id);
            $stmt->execute();
            if($stmt->rowCount() > 0) return $stmt->fetch();
            return [];
        } catch (\PDOException $e) {
            return [];
        }
    }
}