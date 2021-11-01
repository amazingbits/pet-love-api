<?php

namespace App\Model\AgendaDAO;

use App\Model\BaseDAO\iBaseDAO;

interface iAgendaDAO extends iBaseDAO
{
    public function verificarChoqueDeHorario(int $diaSemana, string $horaInicial, string $horaFinal, int $idUsuario): bool;

    public function listarAgendasPorIdUsuario(int $idUsuario, bool $active = true): array;

    public function listarDatasDeAtendimentoPorMes(string $data, int $idAgenda): array;

    public function findByDateAndId(string $date, int $scheduleId): array;
}