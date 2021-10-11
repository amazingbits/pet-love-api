<?php

namespace App\Controller;

use App\Core\DefaultController;
use App\Helper\DateHelper;
use App\Helper\ParamsHelper;
use App\Model\AgendaDAO\AgendaDAO;
use App\Model\AgendaItemDAO\AgendaItemDAO;
use App\Model\AnimalDAO\AnimalDAO;
use App\Model\BloqueioDAO\BloqueioDAO;

class AgendaItemController extends DefaultController
{
    private ParamsHelper $params;
    private DateHelper $dateHelper;
    private AgendaItemDAO $agendaItemDAO;
    private AgendaDAO $agendaDAO;
    private AnimalDAO $animalDAO;
    private BloqueioDAO $bloqueioDAO;

    public function __construct()
    {
        $this->params = new ParamsHelper();
        $this->dateHelper = new DateHelper();
        $this->agendaItemDAO = new AgendaItemDAO();
        $this->agendaDAO = new AgendaDAO();
        $this->animalDAO = new AnimalDAO();
        $this->bloqueioDAO = new BloqueioDAO();
    }

    public function getById($data)
    {
        $id = (int)$data["id"];
        $this->response($this->agendaItemDAO->selectById($id));
    }

    public function getByUser($data)
    {
        $idUser = (int)$data["id"];
        $date = $data["date"];
        $this->response($this->agendaItemDAO->listarAtendimentosDoDia($idUser, $date));
    }

    public function save()
    {
        $params = $this->params->getJsonParams();
        $needle = [
            "agenda" => "integer",
            "animal" => "integer",
            "data" => "string",
            "hora" => "string",
            "status" => "string"
        ];
        if(!$this->params->validateParams($params, $needle)) {
            $this->response([
                "message" => "Parâmetros insuficientes ou tipos de parâmetros inválidos!"
            ], HTTP_BAD_REQUEST);
        }

        if(empty($this->agendaDAO->selectById((int)$params["agenda"]))) {
            $this->response([
                "message" => "Agenda inexistente!"
            ], HTTP_BAD_REQUEST);
        }

        if(empty($this->animalDAO->selectById((int)$params["animal"]))) {
            $this->response([
                "message" => "Animal inexistente!"
            ], HTTP_BAD_REQUEST);
        }

        if(!$this->dateHelper->isSqlDate($params["data"])) {
            $this->response([
                "message" => "Insira uma data válida!"
            ], HTTP_BAD_REQUEST);
        }

        if(!$this->dateHelper->isTime($params["hora"])) {
            $this->response([
                "message" => "Insira uma hora válida!"
            ], HTTP_BAD_REQUEST);
        }

        if($this->bloqueioDAO->verificarSeHaBloqueioNaDataEspecificada((int)$params["agenda"], $params["data"])) {
            $this->response([
                "message" => "Esta agenda está bloqueada nesta data. Tente outro dia!"
            ], HTTP_BAD_REQUEST);
        }

        if($this->agendaItemDAO->verificarSeHorarioEstaOcupado((int)$params["agenda"], $params["data"], $params["hora"])) {
            $this->response([
                "message" => "Já existe uma marcação neste dia e horário! Tente outro horário!"
            ], HTTP_BAD_REQUEST);
        }

        if($this->agendaItemDAO->insert($params)) {
            $this->response([
                "message" => "Registro inserido com sucesso!"
            ], HTTP_CREATED);
        }
        $this->response([
            "message" => "Erro ao inserir o registro!"
        ], HTTP_INTERNAL_SERVER_ERROR);
    }

    public function delete($data = [])
    {
        $id = (int)$data["id"];

        if (!$this->agendaItemDAO->compare(["id" => $id])) {
            $this->response([
                "message" => "Não existe registro com este ID"
            ], HTTP_NOT_FOUND);
        }

        if ($this->agendaItemDAO->delete($id)) {
            $this->response([
                "message" => "Registro deletado com sucesso!"
            ], HTTP_CREATED);
        }

        $this->response([
            "message" => "Erro ao deletar registro!"
        ], HTTP_INTERNAL_SERVER_ERROR);
    }
}