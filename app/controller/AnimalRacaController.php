<?php

namespace App\Controller;

use App\Core\DefaultController;
use App\Helper\ParamsHelper;
use App\Model\AnimalRacaDAO\AnimalRacaDAO;
use App\Model\TipoAnimalDAO\TipoAnimalDAO;

class AnimalRacaController extends DefaultController
{
    private ParamsHelper $params;
    private AnimalRacaDAO $animalRacaDAO;
    private TipoAnimalDAO $tipoAnimalDAO;

    public function __construct()
    {
        $this->params = new ParamsHelper();
        $this->animalRacaDAO = new AnimalRacaDAO();
        $this->tipoAnimalDAO = new TipoAnimalDAO();
    }

    public function all()
    {
        $this->response($this->animalRacaDAO->selectAll());
    }

    public function getById($data)
    {
        $id = (int)$data["id"];
        $this->response($this->animalRacaDAO->selectById($id));
    }

    public function save()
    {
        $params = $this->params->getJsonParams();
        $needle = [
            "descricao" => "string",
            "tipo_animal" => "integer"
        ];
        if(!$this->params->validateParams($params, $needle)) {
            $this->response([
                "message" => "Parâmetros insuficientes ou tipos de parâmetros inválidos!"
            ], HTTP_BAD_REQUEST);
        }

        $compareParams = [
            "email" => $params["descricao"]
        ];
        if($this->animalRacaDAO->compare($compareParams)) {
            $this->response([
                "message" => "Já existem registro com esta descrição"
            ], HTTP_BAD_REQUEST);
        }

        if(empty($this->tipoAnimalDAO->selectById((int)$params["tipo_animal"]))) {
            $this->response([
                "message" => "Não existe tipo de animal com o ID informado"
            ], HTTP_BAD_REQUEST);
        }

        if($this->animalRacaDAO->insert($params)) {
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
            "tipo_animal" => "integer"
        ];
        if(!$this->params->validateParams($params, $needle)) {
            $this->response([
                "message" => "Parâmetros insuficientes ou tipos de parâmetros inválidos!"
            ], HTTP_BAD_REQUEST);
        }

        $compareParams = [
            "descricao" => $params["descricao"]
        ];
        $raca = $this->animalRacaDAO->selectById($id);
        $descricaoAtual = $raca["descricao"];
        if($this->animalRacaDAO->compare($compareParams, "=", true, ["descricao" => $descricaoAtual])) {
            $this->response([
                "message" => "Já existem registros com esta descrição"
            ], HTTP_BAD_REQUEST);
        }

        if($this->animalRacaDAO->update($params, ["id" => $id])) {
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

        if (!$this->animalRacaDAO->compare(["id" => $id])) {
            $this->response([
                "message" => "Não existe registro com este ID"
            ], HTTP_NOT_FOUND);
        }

        if ($this->animalRacaDAO->delete($id)) {
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

        if (!$this->animalRacaDAO->compare(["id" => $id])) {
            $this->response([
                "message" => "Não existe registro com este ID"
            ], HTTP_NOT_FOUND);
        }

        if ($this->animalRacaDAO->disable($id, $visibility)) {
            $this->response([
                "message" => "Visibilidade do registro alterada com sucesso!"
            ], HTTP_CREATED);
        }

        $this->response([
            "message" => "Erro ao alterar visibilidade do registro!"
        ], HTTP_INTERNAL_SERVER_ERROR);
    }
}