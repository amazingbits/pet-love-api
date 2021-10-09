<?php

namespace App\Controller;

use App\Core\DefaultController;
use App\Helper\ParamsHelper;
use App\Model\UsuarioDAO\UsuarioDAO;

class UsuarioController extends DefaultController
{
    private ParamsHelper $params;
    private UsuarioDAO $usuarioDAO;

    public function __construct()
    {
        $this->params = new ParamsHelper();
        $this->usuarioDAO = new UsuarioDAO();
    }

    public function all($data)
    {
        $orderColumn = $data["orderColumn"];
        $orderDirection = $data["orderDirection"];
        $limit = (int)$data["limit"];
        $offset = (int)$data["offset"];
        $justActive = (bool)$data["justActive"];
        $this->response($this->usuarioDAO->selectAll($orderColumn, $orderDirection, $limit, $offset, $justActive));
    }

    public function getById($data)
    {
        $id = (int)$data["id"];
        $this->response($this->usuarioDAO->selectById($id));
    }

    public function save()
    {
        $params = $this->params->getJsonParams();
        $needle = [
            "login" => "string",
            "senha" => "string",
            "nome" => "string",
            "email" => "string",
            "telefone" => "string",
            "path_url" => "string",
            "tipo_usuario" => "integer"
        ];
        if(!$this->params->validateParams($params, $needle)) {
            $this->response([
                "message" => "Parâmetros insuficientes ou tipos de parâmetros inválidos!"
            ], HTTP_BAD_REQUEST);
        }

        $params["senha"] = md5($params["senha"]);

        if(!filter_var($params["email"], FILTER_VALIDATE_EMAIL)) {
            $this->response([
                "message" => "E-mail inválido!"
            ], HTTP_BAD_REQUEST);
        }

        $compareParams = [
            "email" => $params["email"],
            "login" => $params["login"]
        ];
        if($this->usuarioDAO->compare($compareParams)) {
            $this->response([
                "message" => "Já existem usuários com este login ou email"
            ], HTTP_BAD_REQUEST);
        }

        if($this->usuarioDAO->insert($params)) {
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
            "login" => "string",
            "nome" => "string",
            "email" => "string",
            "telefone" => "string",
            "path_url" => "string",
            "tipo_usuario" => "integer"
        ];
        if(!$this->params->validateParams($params, $needle)) {
            $this->response([
                "message" => "Parâmetros insuficientes ou tipos de parâmetros inválidos!"
            ], HTTP_BAD_REQUEST);
        }

        if(!filter_var($params["email"], FILTER_VALIDATE_EMAIL)) {
            $this->response([
                "message" => "E-mail inválido!"
            ], HTTP_BAD_REQUEST);
        }

        $compareParams = [
            "email" => $params["email"],
            "login" => $params["login"]
        ];
        $usuario = $this->usuarioDAO->selectById($id);
        $loginAtual = $usuario["login"];
        $emailAtual = $usuario["email"];
        if($this->usuarioDAO->compare($compareParams, "=", true, ["login" => $loginAtual, "email" => $emailAtual])) {
            $this->response([
                "message" => "Já existem usuários com este login ou email"
            ], HTTP_BAD_REQUEST);
        }

        if($this->usuarioDAO->update($params, ["id" => $id])) {
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

        if (!$this->usuarioDAO->compare(["id" => $id])) {
            $this->response([
                "message" => "Não existe registro com este ID"
            ], HTTP_NOT_FOUND);
        }

        if ($this->usuarioDAO->delete($id)) {
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

        if (!$this->usuarioDAO->compare(["id" => $id])) {
            $this->response([
                "message" => "Não existe registro com este ID"
            ], HTTP_NOT_FOUND);
        }

        if ($this->usuarioDAO->disable($id, $visibility)) {
            $this->response([
                "message" => "Visibilidade do registro alterada com sucesso!"
            ], HTTP_CREATED);
        }

        $this->response([
            "message" => "Erro ao alterar visibilidade do registro!"
        ], HTTP_INTERNAL_SERVER_ERROR);
    }
}