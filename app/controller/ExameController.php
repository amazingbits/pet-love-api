<?php

namespace App\Controller;

use App\Core\DefaultController;
use App\Helper\DateHelper;
use App\Helper\ParamsHelper;
use App\Model\AnimalDAO\AnimalDAO;
use App\Model\ExameDAO\ExameDAO;

class ExameController extends DefaultController
{
    private ParamsHelper $params;
    private DateHelper $dateHelper;
    private ExameDAO $exameDAO;
    private AnimalDAO $animalDAO;

    public function __construct()
    {
        $this->params = new ParamsHelper();
        $this->dateHelper = new DateHelper();
        $this->exameDAO = new ExameDAO();
        $this->animalDAO = new AnimalDAO();
    }

    public function all($data)
    {
        $orderColumn = $data["orderColumn"];
        $orderDirection = $data["orderDirection"];
        $limit = (int)$data["limit"];
        $offset = (int)$data["offset"];
        $justActive = (bool)$data["justActive"];
        $this->response($this->exameDAO->selectAll($orderColumn, $orderDirection, $limit, $offset, $justActive));
    }

    public function getById($data)
    {
        $id = (int)$data["id"];
        $this->response($this->exameDAO->selectById($id));
    }

    public function save()
    {
        $params = $this->params->getJsonParams();
        $needle = [
            "descricao" => "string",
            "data" => "string",
            "notas" => "string",
            "file_path" => "string",
            "animal" => "integer"
        ];
        if(!$this->params->validateParams($params, $needle)) {
            $this->response([
                "message" => "Parâmetros insuficientes ou tipos de parâmetros inválidos!"
            ], HTTP_BAD_REQUEST);
        }

        if(!$this->dateHelper->isSqlDate($params["data"])) {
            $this->response([
                "message" => "Insira uma data válida!"
            ], HTTP_BAD_REQUEST);
        }

        if($this->dateHelper->isBigger($params["data"], date("Y-m-d"))) {
            $this->response([
                "message" => "A data inserida não pode ser maior que a data de hoje!"
            ], HTTP_BAD_REQUEST);
        }

        if(empty($this->animalDAO->selectById((int)$params["animal"]))) {
            $this->response([
                "message" => "Nenhum animal com este ID encontrado!"
            ], HTTP_BAD_REQUEST);
        }

        if($this->exameDAO->insert($params)) {
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
            "data" => "string",
            "notas" => "string",
            "file_path" => "string",
            "animal" => "integer"
        ];
        if(!$this->params->validateParams($params, $needle)) {
            $this->response([
                "message" => "Parâmetros insuficientes ou tipos de parâmetros inválidos!"
            ], HTTP_BAD_REQUEST);
        }

        if(!$this->dateHelper->isSqlDate($params["data"])) {
            $this->response([
                "message" => "Insira uma data válida!"
            ], HTTP_BAD_REQUEST);
        }

        if($this->dateHelper->isBigger($params["data"], date("Y-m-d"))) {
            $this->response([
                "message" => "A data inserida não pode ser maior que a data de hoje!"
            ], HTTP_BAD_REQUEST);
        }

        if(empty($this->animalDAO->selectById((int)$params["animal"]))) {
            $this->response([
                "message" => "Nenhum animal com este ID encontrado!"
            ], HTTP_BAD_REQUEST);
        }

        if($this->exameDAO->update($params, ["id" => $id])) {
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

        if (!$this->exameDAO->compare(["id" => $id])) {
            $this->response([
                "message" => "Não existe registro com este ID"
            ], HTTP_NOT_FOUND);
        }

        if ($this->exameDAO->delete($id)) {
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

        if (!$this->exameDAO->compare(["id" => $id])) {
            $this->response([
                "message" => "Não existe registro com este ID"
            ], HTTP_NOT_FOUND);
        }

        if ($this->exameDAO->disable($id, $visibility)) {
            $this->response([
                "message" => "Visibilidade do registro alterada com sucesso!"
            ], HTTP_CREATED);
        }

        $this->response([
            "message" => "Erro ao alterar visibilidade do registro!"
        ], HTTP_INTERNAL_SERVER_ERROR);
    }
}