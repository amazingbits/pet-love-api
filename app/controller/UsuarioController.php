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
        $this->response($this->usuarioDAO->pegarUsuarioComEnderecoEAnimais($orderColumn, $orderDirection, $limit, $offset, $justActive));
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
            "nome" => "string",
            "senha" => "string",
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
            "email" => $params["email"]
        ];
        if($this->usuarioDAO->compare($compareParams)) {
            $this->response([
                "message" => "Já existem usuários com este email"
            ], HTTP_BAD_REQUEST);
        }

        $telefone = preg_replace("/[^0-9]/", "", $params["telefone"]);
        $dt = [
            "nome" => trim($params["nome"]),
            "senha" => trim($params["senha"]),
            "email" => trim($params["email"]),
            "telefone" => $telefone,
            "path_url" => trim($params["path_url"]),
            "tipo_usuario" => (int)$params["tipo_usuario"]
        ];
        if($this->usuarioDAO->insert($dt)) {
            $this->response([
                "message" => "Registro inserido com sucesso!",
                "id" => $this->usuarioDAO->getLastId()
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
            "email" => $params["email"]
        ];
        $usuario = $this->usuarioDAO->selectById($id);
        $emailAtual = $usuario["email"];
        if($this->usuarioDAO->compare($compareParams, "=", true, ["email" => $emailAtual])) {
            $this->response([
                "message" => "Já existem usuários com este email"
            ], HTTP_BAD_REQUEST);
        }

        $telefone = preg_replace("/[^0-9]/", "", $params["telefone"]);
        $dt = [
            "nome" => trim($params["nome"]),
            "senha" => trim($params["senha"]),
            "email" => trim($params["email"]),
            "telefone" => $telefone,
            "path_url" => trim($params["path_url"]),
            "tipo_usuario" => (int)$params["tipo_usuario"]
        ];
        if($this->usuarioDAO->update($dt, ["id" => $id])) {
            $this->response([
                "message" => "Registro atualizado com sucesso!"
            ], HTTP_CREATED);
        }
        $this->response([
            "message" => "Erro ao atualizar o registro!"
        ], HTTP_INTERNAL_SERVER_ERROR);
    }

    public function updatePassword($data)
    {
        $userId = (int)$data["userId"];

        $params = $this->params->getJsonParams();
        $needle = [
            "senha" => "string"
        ];
        if(!$this->params->validateParams($params, $needle)) {
            $this->response([
                "message" => "Parâmetros insuficientes ou tipos de parâmetros inválidos!"
            ], HTTP_BAD_REQUEST);
        }

        $senha = md5($params["senha"]);
        if($this->usuarioDAO->changePassword($userId, $senha)) {
            $this->response([
                "message" => "Senha alterada com sucesso!"
            ]);
        }
        $this->response([
            "message" => "Houve um problema para alterar a senha do usuário!"
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

    public function pesquisarEmpresasPorRaio($data)
    {
        $latitude = (float)$data["latitude"];
        $longitude = (float)$data["longitude"];
        $this->response($this->usuarioDAO->pesquisarEmpresasPorRaio($latitude, $longitude));
    }

    public function findCompaniesByName($data)
    {
        $name = trim($data["name"]);
        $this->response($this->usuarioDAO->findCompaniesByName($name));
    }

    public function findCompanies()
    {
        $this->response($this->usuarioDAO->findCompaniesByName(""));
    }

    public function newUserByApp()
    {
        $params = $this->params->getJsonParams();
        $needle = [
            "name" => "string",
            "password" => "string",
            "email" => "string",
            "phone" => "string",
            "path_url" => "string",
            "user_type" => "integer"
        ];
        if(!$this->params->validateParams($params, $needle)) {
            $this->response([
                "message" => "Parâmetros insuficientes ou tipos de parâmetros inválidos!"
            ], HTTP_BAD_REQUEST);
        }

        if(!filter_var($params["email"], FILTER_VALIDATE_EMAIL)) {
            $this->response([
                "message" => "Insira um e-mail válido!",
                "status" => HTTP_BAD_REQUEST
            ], HTTP_BAD_REQUEST);
        }

        if(!empty($this->usuarioDAO->getByEmail($params["email"]))) {
            $this->response([
                "message" => "Já existe um usuário com este e-mail!",
                "status" => HTTP_BAD_REQUEST
            ], HTTP_BAD_REQUEST);
        }

        $phone = preg_replace('/[^0-9]/', "", $params["phone"]);
        $password = md5(trim($params["password"]));
        $userParams = [
            "name" => trim($params["name"]),
            "email" => trim($params["email"]),
            "phone" => $phone,
            "path_url" => "",
            "password" => $password,
            "user_type" => 1
        ];

        if($this->usuarioDAO->newUserByApp($userParams)) {
            $this->response([
                "message" => "Usuário criado com sucesso!",
                "status" => 201
            ], HTTP_CREATED);
        } else {
            $this->response([
                "message" => "Houve um problema ao criar o usuário!",
                "status" => HTTP_INTERNAL_SERVER_ERROR
            ], HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}