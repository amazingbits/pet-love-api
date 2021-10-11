<?php

namespace App\Controller;

use App\Core\DefaultController;
use App\Helper\ParamsHelper;
use App\Model\AvaliacaoDAO\AvaliacaoDAO;
use App\Model\UsuarioDAO\UsuarioDAO;

class AvaliacaoController extends DefaultController
{
    private ParamsHelper $params;
    private AvaliacaoDAO $avaliacaoDAO;
    private UsuarioDAO $usuarioDAO;

    public function __construct()
    {
        $this->params = new ParamsHelper();
        $this->avaliacaoDAO = new AvaliacaoDAO();
        $this->usuarioDAO = new UsuarioDAO();
    }

    public function all($data)
    {
        $this->response($this->avaliacaoDAO->selectAll());
    }

    public function getById($data)
    {
        $id = (int)$data["id"];
        $this->response($this->avaliacaoDAO->selectById($id));
    }

    public function getByUser($data)
    {
        $id = (int)$data["id"];
        $this->response($this->avaliacaoDAO->getByUser($id));
    }

    public function save()
    {
        $params = $this->params->getJsonParams();
        $needle = [
            "empresa" => "integer",
            "usuario" => "integer",
            "nota" => "integer",
            "descricao" => "string"
        ];
        if(!$this->params->validateParams($params, $needle)) {
            $this->response([
                "message" => "Parâmetros insuficientes ou tipos de parâmetros inválidos!"
            ], HTTP_BAD_REQUEST);
        }

        if(empty($this->usuarioDAO->selectById((int)$params["empresa"]))) {
            $this->response([
                "message" => "Não existe empresa com o ID informado"
            ], HTTP_BAD_REQUEST);
        }

        if(empty($this->usuarioDAO->selectById((int)$params["usuario"]))) {
            $this->response([
                "message" => "Não existe usuario com o ID informado"
            ], HTTP_BAD_REQUEST);
        }

        if((int)$params["nota"] < 0 || (int)$params["nota"] > 5) {
            $this->response([
                "message" => "Insira uma nota entre 1 e 5"
            ], HTTP_BAD_REQUEST);
        }

        if($this->avaliacaoDAO->insert($params)) {
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
            "empresa" => "integer",
            "usuario" => "integer",
            "nota" => "integer",
            "descricao" => "string"
        ];
        if(!$this->params->validateParams($params, $needle)) {
            $this->response([
                "message" => "Parâmetros insuficientes ou tipos de parâmetros inválidos!"
            ], HTTP_BAD_REQUEST);
        }

        if(empty($this->usuarioDAO->selectById((int)$params["empresa"]))) {
            $this->response([
                "message" => "Não existe empresa com o ID informado"
            ], HTTP_BAD_REQUEST);
        }

        if(empty($this->usuarioDAO->selectById((int)$params["usuario"]))) {
            $this->response([
                "message" => "Não existe usuario com o ID informado"
            ], HTTP_BAD_REQUEST);
        }

        if((int)$params["nota"] < 0 || (int)$params["nota"] > 5) {
            $this->response([
                "message" => "Insira uma nota entre 1 e 5"
            ], HTTP_BAD_REQUEST);
        }

        if($this->avaliacaoDAO->update($params, ["id" => $id])) {
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

        if (!$this->avaliacaoDAO->compare(["id" => $id])) {
            $this->response([
                "message" => "Não existe registro com este ID"
            ], HTTP_NOT_FOUND);
        }

        if ($this->avaliacaoDAO->delete($id)) {
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

        if (!$this->avaliacaoDAO->compare(["id" => $id])) {
            $this->response([
                "message" => "Não existe registro com este ID"
            ], HTTP_NOT_FOUND);
        }

        if ($this->avaliacaoDAO->disable($id, $visibility)) {
            $this->response([
                "message" => "Visibilidade do registro alterada com sucesso!"
            ], HTTP_CREATED);
        }

        $this->response([
            "message" => "Erro ao alterar visibilidade do registro!"
        ], HTTP_INTERNAL_SERVER_ERROR);
    }
}