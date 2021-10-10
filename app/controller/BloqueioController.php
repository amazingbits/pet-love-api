<?php

namespace App\Controller;

use App\Core\DefaultController;
use App\Helper\DateHelper;
use App\Helper\ParamsHelper;
use App\Model\AgendaDAO\AgendaDAO;
use App\Model\BloqueioDAO\BloqueioDAO;

class BloqueioController extends DefaultController
{
    private ParamsHelper $params;
    private DateHelper $dateHelper;
    private BloqueioDAO $bloqueioDAO;
    private AgendaDAO $agendaDAO;

    public function __construct()
    {
        $this->params = new ParamsHelper();
        $this->dateHelper = new DateHelper();
        $this->bloqueioDAO = new BloqueioDAO();
        $this->agendaDAO = new AgendaDAO();
    }

    public function all()
    {
        $this->response($this->bloqueioDAO->selectAll());
    }

    public function getById($data)
    {
        $id = (int)$data["id"];
        $this->response($this->bloqueioDAO->selectById($id));
    }

    public function save()
    {
        $params = $this->params->getJsonParams();
        $needle = [
            "descricao" => "string",
            "agenda" => "integer",
            "data_inicial" => "string",
            "data_final" => "string"
        ];
        if(!$this->params->validateParams($params, $needle)) {
            $this->response([
                "message" => "Parâmetros insuficientes ou tipos de parâmetros inválidos!"
            ], HTTP_BAD_REQUEST);
        }

        if(!$this->dateHelper->isSqlDate($params["data_inicial"]) || !$this->dateHelper->isSqlDate($params["data_final"])) {
            $this->response([
                "message" => "Ambas as datas devem ser válidas!"
            ], HTTP_BAD_REQUEST);
        }

        if($this->dateHelper->isBigger($params["data_inicial"], $params["data_final"])) {
            $this->response([
                "message" => "A data inicial não pode ser superior à data final!"
            ], HTTP_BAD_REQUEST);
        }

        if(empty($this->agendaDAO->selectById((int)$params["agenda"]))) {
            $this->response([
                "message" => "Agenda não encontrada!"
            ], HTTP_BAD_REQUEST);
        }

        if($this->bloqueioDAO->insert($params)) {
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
            "agenda" => "integer",
            "data_inicial" => "string",
            "data_final" => "string"
        ];
        if(!$this->params->validateParams($params, $needle)) {
            $this->response([
                "message" => "Parâmetros insuficientes ou tipos de parâmetros inválidos!"
            ], HTTP_BAD_REQUEST);
        }

        if(!$this->dateHelper->isSqlDate($params["data_inicial"]) || !$this->dateHelper->isSqlDate($params["data_final"])) {
            $this->response([
                "message" => "Ambas as datas devem ser válidas!"
            ], HTTP_BAD_REQUEST);
        }

        if($this->dateHelper->isBigger($params["data_inicial"], $params["data_final"])) {
            $this->response([
                "message" => "A data inicial não pode ser superior à data final!"
            ], HTTP_BAD_REQUEST);
        }

        if(empty($this->agendaDAO->selectById((int)$params["agenda"]))) {
            $this->response([
                "message" => "Agenda não encontrada!"
            ], HTTP_BAD_REQUEST);
        }

        if($this->bloqueioDAO->update($params, ["id" => $id])) {
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

        if (!$this->bloqueioDAO->compare(["id" => $id])) {
            $this->response([
                "message" => "Não existe registro com este ID"
            ], HTTP_NOT_FOUND);
        }

        if ($this->bloqueioDAO->delete($id)) {
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

        if (!$this->bloqueioDAO->compare(["id" => $id])) {
            $this->response([
                "message" => "Não existe registro com este ID"
            ], HTTP_NOT_FOUND);
        }

        if ($this->bloqueioDAO->disable($id, $visibility)) {
            $this->response([
                "message" => "Visibilidade do registro alterada com sucesso!"
            ], HTTP_CREATED);
        }

        $this->response([
            "message" => "Erro ao alterar visibilidade do registro!"
        ], HTTP_INTERNAL_SERVER_ERROR);
    }
}