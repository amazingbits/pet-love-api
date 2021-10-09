<?php

namespace App\Controller;

use App\Core\DefaultController;
use App\Helper\ParamsHelper;
use App\Model\AnimalComportamentoDAO\AnimalComportamentoDAO;
use App\Model\AnimalDAO\AnimalDAO;
use App\Model\AnimalRacaDAO\AnimalRacaDAO;
use App\Model\TipoAnimalDAO\TipoAnimalDAO;
use App\Model\UsuarioDAO\UsuarioDAO;

class AnimalController extends DefaultController
{
    private ParamsHelper $params;
    private AnimalDAO $animalDAO;
    private AnimalComportamentoDAO $animalComportamentoDAO;
    private TipoAnimalDAO $tipoAnimalDAO;
    private AnimalRacaDAO $animalRacaDAO;
    private UsuarioDAO $usuarioDAO;

    public function __construct()
    {
        $this->params = new ParamsHelper();
        $this->animalDAO = new AnimalDAO();
        $this->animalComportamentoDAO = new AnimalComportamentoDAO();
        $this->tipoAnimalDAO = new TipoAnimalDAO();
        $this->animalRacaDAO = new AnimalRacaDAO();
        $this->usuarioDAO = new UsuarioDAO();
    }

    public function all($data)
    {
        $orderColumn = $data["orderColumn"];
        $orderDirection = $data["orderDirection"];
        $limit = (int)$data["limit"];
        $offset = (int)$data["offset"];
        $justActive = (bool)$data["justActive"];
        $this->response($this->animalDAO->selectAll($orderColumn, $orderDirection, $limit, $offset, $justActive));
    }

    public function getById($data)
    {
        $id = (int)$data["id"];
        $this->response($this->animalDAO->selectById($id));
    }

    public function save()
    {
        $params = $this->params->getJsonParams();
        $needle = [
            "sexo" => "string",
            "nome" => "string",
            "nascimento" => "string",
            "castrado" => "integer",
            "animal_raca" => "integer",
            "animal_comportamento" => "integer",
            "tipo_animal" => "integer",
            "dono" => "integer"
        ];
        if(!$this->params->validateParams($params, $needle)) {
            $this->response([
                "message" => "Parâmetros insuficientes ou tipos de parâmetros inválidos!"
            ], HTTP_BAD_REQUEST);
        }

        if(
            empty($this->animalRacaDAO->selectById((int)$params["animal_raca"])) ||
            empty($this->animalComportamentoDAO->selectById((int)$params["animal_comportamento"])) ||
            empty($this->tipoAnimalDAO->selectById((int)$params["tipo_animal"])) ||
            empty($this->usuarioDAO->selectById((int)$params["dono"]))
        ) {
            $this->response([
                "message" => "Registros insuficientes!"
            ], HTTP_BAD_REQUEST);
        }

        if($this->animalDAO->insert($params)) {
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
            "sexo" => "string",
            "nome" => "string",
            "nascimento" => "string",
            "castrado" => "integer",
            "animal_raca" => "integer",
            "animal_comportamento" => "integer",
            "tipo_animal" => "integer",
            "dono" => "integer"
        ];
        if(!$this->params->validateParams($params, $needle)) {
            $this->response([
                "message" => "Parâmetros insuficientes ou tipos de parâmetros inválidos!"
            ], HTTP_BAD_REQUEST);
        }

        if(
            empty($this->animalRacaDAO->selectById((int)$params["animal_raca"])) ||
            empty($this->animalComportamentoDAO->selectById((int)$params["animal_comportamento"])) ||
            empty($this->tipoAnimalDAO->selectById((int)$params["tipo_animal"])) ||
            empty($this->usuarioDAO->selectById((int)$params["dono"]))
        ) {
            $this->response([
                "message" => "Registros insuficientes!"
            ], HTTP_BAD_REQUEST);
        }

        if($this->animalDAO->update($params, ["id" => $id])) {
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

        if (!$this->animalDAO->compare(["id" => $id])) {
            $this->response([
                "message" => "Não existe registro com este ID"
            ], HTTP_NOT_FOUND);
        }

        if ($this->animalDAO->delete($id)) {
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

        if (!$this->animalDAO->compare(["id" => $id])) {
            $this->response([
                "message" => "Não existe registro com este ID"
            ], HTTP_NOT_FOUND);
        }

        if ($this->animalDAO->disable($id, $visibility)) {
            $this->response([
                "message" => "Visibilidade do registro alterada com sucesso!"
            ], HTTP_CREATED);
        }

        $this->response([
            "message" => "Erro ao alterar visibilidade do registro!"
        ], HTTP_INTERNAL_SERVER_ERROR);
    }
}