<?php

namespace App\Model\AgendaItemDAO;

use App\Model\BaseDAO\iBaseDAO;

interface iAgendaItemDAO extends iBaseDAO
{
    public function listarAtendimentosDoDia(int $idUser, string $date): array;

    public function listarAtendimentosDoDiaPorIdAgenda(int $idAgenda, string $date): array;

    public function verificarSeHorarioEstaOcupado(int $idAgenda, string $data, string $hora): bool;

    public function pegarAgendaPorDataEId(int $idAgenda, string $data): array;

    public function agendaPorDataHoraId(int $idAgenda, string $data, string $hora): array;

    public function agendaParaOsProximosDias(int $idUsuario): array;
}