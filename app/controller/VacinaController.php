<?php

namespace App\Controller;

use App\Core\DefaultController;
use App\Helper\ParamsHelper;
use App\Model\TipoAnimalDAO\TipoAnimalDAO;
use App\Model\VacinaDAO\VacinaDAO;

class VacinaController extends DefaultController
{
    private ParamsHelper $params;
    private VacinaDAO $vacinaDAO;
    private TipoAnimalDAO $tipoAnimalDAO;

    public function __construct()
    {
        $this->params = new ParamsHelper();
        $this->vacinaDAO = new VacinaDAO();
        $this->tipoAnimalDAO = new TipoAnimalDAO();
    }

    public function all()
    {
        $this->response($this->vacinaDAO->selectAll());
    }

    public function getById($data)
    {
        $id = (int)$data["id"];
        $this->response($this->vacinaDAO->selectById($id));
    }

    public function save()
    {
        $params = $this->params->getJsonParams();
        $needle = [
            "descricao" => "string",
            "duracao_dias" => "integer",
            "tipo" => "integer"
        ];
        if(!$this->params->validateParams($params, $needle)) {
            $this->response([
                "message" => "Parâmetros insuficientes ou tipos de parâmetros inválidos!"
            ], HTTP_BAD_REQUEST);
        }

        $compareParams = [
            "descricao" => $params["descricao"]
        ];
        if($this->vacinaDAO->compare($compareParams)) {
            $this->response([
                "message" => "Já existem registro com esta descrição"
            ], HTTP_BAD_REQUEST);
        }

        if(empty($this->tipoAnimalDAO->selectById((int)$params["tipo"]))) {
            $this->response([
                "message" => "Não existe tipo de animal com o ID informado"
            ], HTTP_BAD_REQUEST);
        }

        if($this->vacinaDAO->insert($params)) {
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
            "duracao_dias" => "integer",
            "tipo" => "integer"
        ];
        if(!$this->params->validateParams($params, $needle)) {
            $this->response([
                "message" => "Parâmetros insuficientes ou tipos de parâmetros inválidos!"
            ], HTTP_BAD_REQUEST);
        }

        $compareParams = [
            "descricao" => $params["descricao"]
        ];
        $vacina = $this->vacinaDAO->selectById($id);
        $descricaoAtual = $vacina["descricao"];
        if($this->vacinaDAO->compare($compareParams, "=", true, ["descricao" => $descricaoAtual])) {
            $this->response([
                "message" => "Já existem registros com esta descrição"
            ], HTTP_BAD_REQUEST);
        }

        if($this->vacinaDAO->update($params, ["id" => $id])) {
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

        if (!$this->vacinaDAO->compare(["id" => $id])) {
            $this->response([
                "message" => "Não existe registro com este ID"
            ], HTTP_NOT_FOUND);
        }

        if ($this->vacinaDAO->delete($id)) {
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

        if (!$this->vacinaDAO->compare(["id" => $id])) {
            $this->response([
                "message" => "Não existe registro com este ID"
            ], HTTP_NOT_FOUND);
        }

        if ($this->vacinaDAO->disable($id, $visibility)) {
            $this->response([
                "message" => "Visibilidade do registro alterada com sucesso!"
            ], HTTP_CREATED);
        }

        $this->response([
            "message" => "Erro ao alterar visibilidade do registro!"
        ], HTTP_INTERNAL_SERVER_ERROR);
    }
}