<?php

namespace App\Controller;

use App\Core\DefaultController;
use App\Helper\ParamsHelper;
use App\Model\EnderecoDAO\EnderecoDAO;
use App\Model\UsuarioDAO\UsuarioDAO;

class EnderecoController extends DefaultController
{
    private ParamsHelper $params;
    private EnderecoDAO $enderecoDAO;
    private UsuarioDAO $usuarioDAO;

    public function __construct()
    {
        $this->params = new ParamsHelper();
        $this->enderecoDAO = new EnderecoDAO();
        $this->usuarioDAO = new UsuarioDAO();
    }

    public function all()
    {
        $this->response($this->enderecoDAO->selectAll());
    }

    public function getById($data)
    {
        $id = (int)$data["id"];
        $this->response($this->enderecoDAO->selectById($id));
    }

    public function save()
    {
        $params = $this->params->getJsonParams();
        $needle = [
            "cep" => "string",
            "rua" => "string",
            "numero" => "string",
            "complemento" => "string",
            "cidade" => "string",
            "estado" => "string",
            "latitude" => "string",
            "longitude" => "string",
            "usuario" => "integer"
        ];
        if(!$this->params->validateParams($params, $needle)) {
            $this->response([
                "message" => "Parâmetros insuficientes ou tipos de parâmetros inválidos!"
            ], HTTP_BAD_REQUEST);
        }

        if(empty($this->usuarioDAO->selectById((int)$params["usuario"]))) {
            $this->response([
                "message" => "Não existe usuário com o ID informado"
            ], HTTP_BAD_REQUEST);
        }

        if($this->enderecoDAO->insert($params)) {
            $this->response([
                "message" => "Registro inserido com sucesso!"
            ], HTTP_CREATED);
        }
        $this->response([
            "message" => "Erro ao inserir o registro!"
        ], HTTP_INTERNAL_SERVER_ERROR);
    }

    public function update($data)
    {
        $id = (int)$data["id"];
        $params = $this->params->getJsonParams();
        $needle = [
            "cep" => "string",
            "rua" => "string",
            "numero" => "string",
            "complemento" => "string",
            "cidade" => "string",
            "estado" => "string",
            "latitude" => "string",
            "longitude" => "string",
            "usuario" => "integer"
        ];
        if(!$this->params->validateParams($params, $needle)) {
            $this->response([
                "message" => "Parâmetros insuficientes ou tipos de parâmetros inválidos!"
            ], HTTP_BAD_REQUEST);
        }

        if(empty($this->enderecoDAO->selectById($id))) {
            $this->response([
                "message" => "Não foi encontrado endereço com este ID"
            ], HTTP_BAD_REQUEST);
        }

        if($this->enderecoDAO->update($params, ["id" => $id])) {
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

        if (!$this->enderecoDAO->compare(["id" => $id])) {
            $this->response([
                "message" => "Não existe registro com este ID"
            ], HTTP_NOT_FOUND);
        }

        if ($this->enderecoDAO->delete($id)) {
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

        if (!$this->enderecoDAO->compare(["id" => $id])) {
            $this->response([
                "message" => "Não existe registro com este ID"
            ], HTTP_NOT_FOUND);
        }

        if ($this->enderecoDAO->disable($id, $visibility)) {
            $this->response([
                "message" => "Visibilidade do registro alterada com sucesso!"
            ], HTTP_CREATED);
        }

        $this->response([
            "message" => "Erro ao alterar visibilidade do registro!"
        ], HTTP_INTERNAL_SERVER_ERROR);
    }
}