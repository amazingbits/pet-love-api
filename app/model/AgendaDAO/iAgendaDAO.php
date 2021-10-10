<?php

namespace App\Model\AgendaDAO;

use App\Model\BaseDAO\iBaseDAO;

interface iAgendaDAO extends iBaseDAO
{
    public function verificarChoqueDeHorario(int $diaSemana, string $horaInicial, string $horaFinal, int $idUsuario): bool;

    public function listarAgendasPorIdUsuario(int $idUsuario, bool $active = true): array;
}