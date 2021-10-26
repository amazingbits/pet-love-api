<?php

namespace App\Controller;

use App\Core\DefaultController;
use App\Helper\DateHelper;
use App\Helper\ParamsHelper;
use App\Model\AgendaDAO\AgendaDAO;
use App\Model\UsuarioDAO\UsuarioDAO;

class AgendaController extends DefaultController
{
    private ParamsHelper $params;
    private DateHelper $dateHelper;
    private AgendaDAO $agendaDAO;
    private UsuarioDAO $usuarioDAO;
    private array $diasSemana = ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado"];

    public function __construct()
    {
        $this->params = new ParamsHelper();
        $this->dateHelper = new DateHelper();
        $this->agendaDAO = new AgendaDAO();
        $this->usuarioDAO = new UsuarioDAO();
    }

    public function all($data)
    {
        $orderColumn = $data["orderColumn"];
        $orderDirection = $data["orderDirection"];
        $limit = (int)$data["limit"];
        $offset = (int)$data["offset"];
        $justActive = (bool)$data["justActive"];
        $this->response($this->agendaDAO->selectAll($orderColumn, $orderDirection, $limit, $offset, $justActive));
    }

    public function getById($data)
    {
        $id = (int)$data["id"];
        $this->response($this->agendaDAO->selectById($id));
    }

    public function getByUser($data)
    {
        $idUser = (int)$data["id"];
        $active = (bool)$data["active"];
        $this->response($this->agendaDAO->listarAgendasPorIdUsuario($idUser, $active));
    }

    public function save()
    {
        $params = $this->params->getJsonParams();
        $needle = [
            "descricao" => "string",
            "dia_semana" => "integer",
            "hora_inicio" => "string",
            "hora_fim" => "string",
            "intervalo_atendimento" => "integer",
            "usuario" => "integer"
        ];
        if(!$this->params->validateParams($params, $needle)) {
            $this->response([
                "message" => "Parâmetros insuficientes ou tipos de parâmetros inválidos!"
            ], HTTP_BAD_REQUEST);
        }

        if($params["dia_semana"] < 0 || $params["dia_semana"] > 6) {
            $this->response([
                "message" => "Escolha um dia da semana válido!"
            ], HTTP_BAD_REQUEST);
        }

        $params["dia_semana_ext"] = $this->diasSemana[$params["dia_semana"]];

        if($this->agendaDAO->verificarChoqueDeHorario(
            (int)$params["dia_semana"],
            $params["hora_inicio"],
            $params["hora_fim"],
            (int)$params["usuario"]
        )) {
            $this->response([
                "message" => "Há choque de horário nas agendas. Verifique novamente!"
            ], HTTP_BAD_REQUEST);
        }

        if(!$this->dateHelper->isTime($params["hora_inicio"]) || !$this->dateHelper->isTime($params["hora_fim"])) {
            $this->response([
                "message" => "Os horários de início e fim devem ser válidos!"
            ], HTTP_BAD_REQUEST);
        }

        if($this->dateHelper->timeIsBigger($params["hora_inicio"], $params["hora_fim"])) {
            $this->response([
                "message" => "O horário inicial não pode ser superior ao horário final!"
            ], HTTP_BAD_REQUEST);
        }

        if($params["hora_inicio"] === $params["hora_fim"]) {
            $this->response([
                "message" => "Os horários de início e fim da agenda não podem ser iguais!"
            ], HTTP_BAD_REQUEST);
        }

        if($this->agendaDAO->insert($params)) {
            $this->response([
                "message" => "Registro inserido com sucesso!"
            ], HTTP_CREATED);
        }
        $this->response([
            "message" => "Erro ao inserir o registro!"
        ], HTTP_INTERNAL_SERVER_ERROR);
    }

    public function update($data = [])
    {
        $id = (int)$data["id"];
        $params = $this->params->getJsonParams();
        $needle = [
            "descricao" => "string",
            "dia_semana" => "integer",
            "hora_inicio" => "string",
            "hora_fim" => "string",
            "intervalo_atendimento" => "integer",
            "usuario" => "integer"
        ];
        if(!$this->params->validateParams($params, $needle)) {
            $this->response([
                "message" => "Parâmetros insuficientes ou tipos de parâmetros inválidos!"
            ], HTTP_BAD_REQUEST);
        }

        if($params["dia_semana"] < 0 || $params["dia_semana"] > 6) {
            $this->response([
                "message" => "Escolha um dia da semana válido!"
            ], HTTP_BAD_REQUEST);
        }

        $params["dia_semana_ext"] = $this->diasSemana[$params["dia_semana"]];

        if($this->agendaDAO->verificarChoqueDeHorario(
            (int)$params["dia_semana"],
            $params["hora_inicio"],
            $params["hora_fim"],
            (int)$params["usuario"]
        )) {
            $this->response([
                "message" => "Há choque de horário nas agendas. Verifique novamente!"
            ], HTTP_BAD_REQUEST);
        }

        if(!$this->dateHelper->isTime($params["hora_inicio"]) || !$this->dateHelper->isTime($params["hora_fim"])) {
            $this->response([
                "message" => "Os horários de início e fim devem ser válidos!"
            ], HTTP_BAD_REQUEST);
        }

        if($this->dateHelper->timeIsBigger($params["hora_inicio"], $params["hora_fim"])) {
            $this->response([
                "message" => "O horário inicial não pode ser superior ao horário final!"
            ], HTTP_BAD_REQUEST);
        }

        if($params["hora_inicio"] === $params["hora_fim"]) {
            $this->response([
                "message" => "Os horários de início e fim da agenda não podem ser iguais!"
            ], HTTP_BAD_REQUEST);
        }

        if(empty($this->agendaDAO->selectById($id))) {
            $this->response([
                "message" => "Agenda com este ID não foi encontrada!"
            ], HTTP_BAD_REQUEST);
        }

        if(empty($this->usuarioDAO->selectById((int)$params["usuario"]))) {
            $this->response([
                "message" => "Usuário com este ID não foi encontrado!"
            ], HTTP_BAD_REQUEST);
        }

        if($this->agendaDAO->update($params, ["id" => $id])) {
            $this->response([
                "message" => "Registro atualizado com sucesso!"
            ], HTTP_CREATED);
        }
        $this->response([
            "message" => "Erro ao atualizar o registro!"
        ], HTTP_INTERNAL_SERVER_ERROR);
    }

    public function delete($data = [])
    {
        $id = (int)$data["id"];

        if (!$this->agendaDAO->compare(["id" => $id])) {
            $this->response([
                "message" => "Não existe registro com este ID"
            ], HTTP_NOT_FOUND);
        }

        if ($this->agendaDAO->delete($id)) {
            $this->response([
                "message" => "Registro deletado com sucesso!"
            ], HTTP_CREATED);
        }

        $this->response([
            "message" => "Erro ao deletar registro!"
        ], HTTP_INTERNAL_SERVER_ERROR);
    }

    public function changeVisibility($data = [])
    {
        $id = (int)$data["id"];
        $visibility = (int)$data["visibility"];

        if (!$this->agendaDAO->compare(["id" => $id])) {
            $this->response([
                "message" => "Não existe registro com este ID"
            ], HTTP_NOT_FOUND);
        }

        if ($this->agendaDAO->disable($id, $visibility)) {
            $this->response([
                "message" => "Visibilidade do registro alterada com sucesso!"
            ], HTTP_CREATED);
        }

        $this->response([
            "message" => "Erro ao alterar visibilidade do registro!"
        ], HTTP_INTERNAL_SERVER_ERROR);
    }

    public function listAppointmentByMonth($data)
    {
        $month = $data["date"];
        $idAgenda = (int)$data["id"];
        echo json_encode($this->agendaDAO->listarDatasDeAtendimentoPorMes($month, $idAgenda));
    }

    public function getMyAppointments(array $data)
    {
        $id = (int)$data["userId"];
        $agendas = $this->agendaDAO->listarAgendasPorIdUsuario($id, false);
        $this->response($agendas);
    }
}