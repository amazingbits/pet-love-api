<?php

namespace App\Controller;

use App\Core\DefaultController;
use App\Helper\JWTHelper;
use App\Helper\ParamsHelper;
use App\Model\UsuarioDAO\UsuarioDAO;

class AuthController extends DefaultController
{
    private ParamsHelper $params;
    private JWTHelper $jwt;
    private UsuarioDAO $usuarioDAO;

    public function __construct()
    {
        $this->params = new ParamsHelper();
        $this->jwt = new JWTHelper();
        $this->usuarioDAO = new UsuarioDAO();
    }

    public function loginByApp()
    {
        $params = $this->params->getJsonParams();
        $needle = [
            "email" => "string",
            "senha" => "string"
        ];
        if(!$this->params->validateParams($params, $needle)) {
            $this->response([
                "message" => "Parâmetros insuficientes ou tipos de parâmetros inválidos!"
            ], HTTP_BAD_REQUEST);
        }

        $email = filter_var(trim($params["email"]), FILTER_SANITIZE_STRING);
        $senha = trim($params["senha"]);

        $params = [
            "email" => $email,
            "senha" => md5($senha)
        ];

        if($this->usuarioDAO->compare($params)) {
            $user = $this->usuarioDAO->getByEmail($email);
            $this->response($user);
        }
        $this->response(["message" => "Nenhum usuário encontrado"], HTTP_NOT_FOUND);
    }

    public function login()
    {
        $params = $this->params->getJsonParams();
        $needle = [
            "email" => "string",
            "senha" => "string"
        ];
        if(!$this->params->validateParams($params, $needle)) {
            $this->response([
                "message" => "Parâmetros insuficientes ou tipos de parâmetros inválidos!"
            ], HTTP_BAD_REQUEST);
        }

        $email = filter_var(trim($params["email"]), FILTER_SANITIZE_STRING);
        $senha = trim($params["senha"]);

        $params = [
            "email" => $email,
            "senha" => md5($senha)
        ];
        if($this->usuarioDAO->compare($params)) {

            $user = $this->usuarioDAO->getByEmail($email);
            $this->jwt->setPayload($user);
            $jwtHash = $this->jwt->generateJWT();

            setcookie("hash", $jwtHash, (time() + (10 * 24 * 3600)), "/");

            $this->response([
                "message" => "Logado com sucesso!",
                "hash" => $jwtHash
            ]);
        }
        $this->response([
            "Usuário e/ou senha não encontrados!"
        ], HTTP_NOT_FOUND);
    }

    public function isLogged()
    {
        if(!isset($_COOKIE["hash"])) {
            $this->response([
                "message" => "Você precisa estar logado para este processo!"
            ], HTTP_UNAUTHORIZED);
        }

        $hash = $_COOKIE["hash"];
        $objUser = $this->jwt->decryptJWT($hash);
        $objStructure = ["id", "nome", "email", "telefone"];
        foreach($objStructure as $val) {
            if(!array_key_exists($val, (array)$objUser)) {
                $this->response([
                    "message" => "Estrutura do token inválida!"
                ], HTTP_UNAUTHORIZED);
            }
        }

        $this->response([
            "message" => "Autenticação está ok!"
        ]);

    }

    public function logout()
    {
        setcookie("hash");
        $this->response([
            "message" => "Deslogado com sucesso!"
        ]);
    }
}