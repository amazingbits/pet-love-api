<?php

namespace App\Model\AgendaDAO;

use App\Core\Connection;
use App\Helper\DateHelper;
use App\Model\AgendaItemDAO\AgendaItemDAO;
use App\Model\BaseDAO\BaseDAO;

class AgendaDAO extends BaseDAO implements iAgendaDAO
{
    private AgendaItemDAO $agendaItemDAO;

    public function __construct()
    {
        $this->setTable("agenda");
        $this->agendaItemDAO = new AgendaItemDAO();
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

    public function listarDatasDeAtendimentoPorMes(string $data, int $idAgenda): array
    {
        $dateHelper = new DateHelper();
        $dayLimit = $dateHelper->addDaysToDate(date("Y-m-d"), 2);
        $agenda = $this->selectById($idAgenda);
        $idAgenda = (int)$agenda["id"];
        $dia_semana = (int)$agenda["dia_semana"];
        $primeiroDiaDoMes = $dateHelper->fisrtDayOfMonth($data);
        $ultimoDiaDoMes = $dateHelper->lastDayOfMonth($data);
        $horarios = [];

        while($primeiroDiaDoMes !== $ultimoDiaDoMes) {

            if((int)date("w", strtotime($primeiroDiaDoMes)) === $dia_semana) {
                if($dateHelper->isBigger($primeiroDiaDoMes, $dayLimit)) {

                    $curr = [
                        "idAgenda" => $idAgenda,
                        "dia_semana" => $dia_semana,
                        "dia_semana_ext" => $agenda["dia_semana_ext"],
                        "data" => $primeiroDiaDoMes,
                        "consultas" => $this->agendaItemDAO->listarAtendimentosDoDiaPorIdAgenda($idAgenda, $primeiroDiaDoMes)
                    ];

                    array_push($horarios, $curr);
                }
            }

            $primeiroDiaDoMes = $dateHelper->addDaysToDate($primeiroDiaDoMes, 1);
        }

        $hr_inicio = $agenda["hora_inicio"];
        $hr_fim = $agenda["hora_fim"];
        $intervalo = (int)$agenda["intervalo_atendimento"];

        return $horarios;
    }
}