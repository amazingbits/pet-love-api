<?php

namespace App\Model\AgendaDAO;

use App\Core\Connection;
use App\Model\BaseDAO\BaseDAO;

class AgendaDAO extends BaseDAO implements iAgendaDAO
{
    public function __construct()
    {
        $this->setTable("agenda");
    }

    public function verificarChoqueDeHorario(int $diaSemana, string $horaInicial, string $horaFinal, int $idUsuario): bool
    {
        $sqlQuery = "SELECT 
                     * FROM agenda 
                     WHERE ((:horaInicial BETWEEN hora_inicio AND hora_fim) 
                     OR (:horaFinal BETWEEN hora_inicio AND hora_fim)) 
                     AND usuario = :idUsuario
                     AND dia_semana = :diaSemana";
        try {
            $conn = Connection::getInstance();
            $stmt = $conn->prepare($sqlQuery);
            $stmt->bindValue(":horaInicial", $horaInicial);
            $stmt->bindValue(":horaFinal", $horaFinal);
            $stmt->bindValue(":usuario", $idUsuario);
            $stmt->bindValue(":diaSemana", $diaSemana);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function listarAgendasPorIdUsuario(int $idUsuario, bool $active = true): array
    {
        $sqlQuery = "SELECT * FROM agenda WHERE usuario = :usuario ";
        if($active) {
            $sqlQuery .= " AND ativo = 1 ";
        }
        try {
            $conn = Connection::getInstance();
            $stmt = $conn->prepare($sqlQuery);
            $stmt->bindValue(":usuario", $idUsuario);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            return [];
        }
    }
}