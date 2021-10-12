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

    public function login()
    {
        $params = $this->params->getJsonParams();
        $needle = [
            "login" => "string",
            "senha" => "string"
        ];
        if(!$this->params->validateParams($params, $needle)) {
            $this->response([
                "message" => "Parâmetros insuficientes ou tipos de parâmetros inválidos!"
            ], HTTP_BAD_REQUEST);
        }

        $login = filter_var(trim($params["login"]), FILTER_SANITIZE_STRING);
        $senha = trim($params["senha"]);

        $params = [
            "login" => $login,
            "senha" => md5($senha)
        ];
        if($this->usuarioDAO->compare($params)) {

            $this->jwt->setPayload($params);
            $jwtHash = $this->jwt->generateJWT();

            setcookie("hash", $jwtHash, (time() + (10 * 24 * 3600))); // 10 dias

            $this->response([
                "message" => "Logado com sucesso!",
                "hash" => $jwtHash
            ]);
        }
        $this->response([
            "Usuário e/ou senha não encontrados!"
        ], HTTP_INTERNAL_SERVER_ERROR);
    }

    public function isLogged()
    {
        if(!isset($_COOKIE["hash"])) {
            $this->response([
                "message" => "Você precisa estar logado para este processo!"
            ], HTTP_UNAUTHORIZED);
        }
    }

    public function logout()
    {
        setcookie("hash");
        $this->response([
            "message" => "Deslogado com sucesso!"
        ]);
    }
}