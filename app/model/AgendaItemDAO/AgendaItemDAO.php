<?php

namespace App\Model\AgendaItemDAO;

use App\Core\Connection;
use App\Model\BaseDAO\BaseDAO;

class AgendaItemDAO extends BaseDAO implements iAgendaItemDAO
{
    public function __construct()
    {
        $this->setTable("agenda_item");
    }

    public function listarAtendimentosDoDia(int $idUser, string $date): array
    {
        $sqlQuery = "SELECT agenda_item.id AS id,
                            agenda_item.agenda AS agenda,
                            agenda.descricao AS descAgenda,
                            animal.nome AS animal,
                            DATE_FORMAT(agenda_item.data, '%d/%m/%Y') AS data,
                            agenda_item.hora AS hora,
                            usuario.nome AS dono,
                            agenda_item.status AS status
                     FROM agenda_item 
                     INNER JOIN agenda ON (agenda_item.agenda = agenda.id) 
                     INNER JOIN animal ON (agenda_item.animal = animal.id) 
                     INNER JOIN usuario ON (animal.dono = usuario.id)
                     WHERE usuario.id = :id AND agenda_item.data = :data 
                     ORDER BY agenda_item.hora ASC";
        try {
            $conn = Connection::getInstance();
            $stmt = $conn->prepare($sqlQuery);
            $stmt->bindValue(":id", $idUser);
            $stmt->bindValue(":data", $date);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function verificarSeHorarioEstaOcupado(int $idAgenda, string $data, string $hora): bool
    {
        $sqlQuery = "SELECT * FROM agenda_item WHERE agenda = :agenda AND data = :data AND hora = :hora";
        try {
            $conn = Connection::getInstance();
            $stmt = $conn->prepare($sqlQuery);
            $stmt->bindValue(":agenda", $idAgenda);
            $stmt->bindValue(":data", $data);
            $stmt->bindValue(":hora", $hora);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function listarAtendimentosDoDiaPorIdAgenda(int $idAgenda, string $date): array
    {
        $sqlQuery = "SELECT agenda_item.id AS id,
                            agenda_item.agenda AS agenda,
                            agenda.descricao AS descAgenda,
                            animal.nome AS animal,
                            DATE_FORMAT(agenda_item.data, '%d/%m/%Y') AS data,
                            agenda_item.hora AS hora,
                            usuario.nome AS dono,
                            agenda_item.status AS status
                     FROM agenda_item 
                     INNER JOIN agenda ON (agenda_item.agenda = agenda.id) 
                     INNER JOIN animal ON (agenda_item.animal = animal.id) 
                     INNER JOIN usuario ON (animal.dono = usuario.id)
                     WHERE agenda_item.agenda = :id AND agenda_item.data = :data 
                     ORDER BY agenda_item.hora ASC";
        try {
            $conn = Connection::getInstance();
            $stmt = $conn->prepare($sqlQuery);
            $stmt->bindValue(":id", $idAgenda);
            $stmt->bindValue(":data", $date);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            return [];
        }
    }
}