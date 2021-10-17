<?php

namespace App\Controller;

use App\Core\DefaultController;
use App\Helper\EmailHelper;
use App\Helper\JWTHelper;
use App\Helper\ParamsHelper;
use App\Helper\UtilsHelper;
use App\Model\UsuarioDAO\UsuarioDAO;

class ForgotPasswordController extends DefaultController
{
    private ParamsHelper $params;
    private UtilsHelper $utilsHelper;
    private JWTHelper $jwt;
    private EmailHelper $email;
    private UsuarioDAO $usuarioDAO;

    public function __construct()
    {
        $this->params = new ParamsHelper();
        $this->utilsHelper = new UtilsHelper();
        $this->jwt = new JWTHelper();
        $this->email = new EmailHelper();
        $this->usuarioDAO = new UsuarioDAO();
    }

    public function changePassword()
    {
        $params = $this->params->getJsonParams();
        $needle = [
            "id" => "integer",
            "codigo" => "string",
            "senha" => "string",
            "jwt" => "string"
        ];
        if(!$this->params->validateParams($params, $needle)) {
            $this->response([
                "message" => "Parâmetros insuficientes ou tipos de parâmetros inválidos!"
            ], HTTP_BAD_REQUEST);
        }

        if(empty($params["jwt"])) {
            $this->response([
                "message" => "Informação de token não encontrada!"
            ], HTTP_BAD_REQUEST);
        }

        $cookieParams = (array)$this->jwt->decryptJWT($params["jwt"]);

        if($cookieParams["codigo"] !== $params["codigo"]) {
            $this->response([
                "message" => "Código inválido!"
            ], HTTP_BAD_REQUEST);
        }

        if(empty($this->usuarioDAO->selectById((int)$params["id"]))) {
            $this->response([
                "message" => "Usuário não encontrado!"
            ], HTTP_BAD_REQUEST);
        }

        if($this->usuarioDAO->changePassword((int)$params["id"], md5($params["senha"]))) {
            $this->response([
                "message" => "Senha alterada com sucesso!"
            ]);
        }
        $this->response([
            "message" => "Erro ao alterar senha do usuário!"
        ], HTTP_INTERNAL_SERVER_ERROR);

    }

    public function verifyCookie($data)
    {
        if(!isset($_COOKIE["forgotpassword"])) {
            $this->response([
                "message" => "Não existe solicitação válida para este procedimento!"
            ], HTTP_UNAUTHORIZED);
        }

        $params = (array)$this->jwt->decryptJWT($_COOKIE["forgotpassword"]);

        $rCodigo = $data["code"];
        if($rCodigo !== $params["codigo"]) {
            $this->response([
                "message" => "Código inválido!"
            ], HTTP_UNAUTHORIZED);
        }

        $rId = (int)$data["idUser"];
        if(empty($this->usuarioDAO->selectById($rId))) {
            $this->response([
                "message" => "Usuário não encontrado!"
            ], HTTP_UNAUTHORIZED);
        }

        $this->response([
            "message" => "Tudo ok!",
            "status" => 200
        ]);
    }

    public function forgotPassword($data)
    {
        $params = $data;
        $needle = [
            "email" => "string"
        ];
        if(!$this->params->validateParams($params, $needle)) {
            $this->response([
                "message" => "Parâmetros insuficientes ou tipos de parâmetros inválidos!"
            ], HTTP_BAD_REQUEST);
        }

        if(!filter_var($params["email"], FILTER_VALIDATE_EMAIL)) {
            $this->response([
                "message" => "Insira um e-mail válido!"
            ], HTTP_BAD_REQUEST);
        }

        $usuario = $this->usuarioDAO->getByEmail($params["email"]);

        if(empty($usuario)) {
            $this->response([
                "message" => "Não foi encontrado um usuário com este e-mail!"
            ], HTTP_NOT_FOUND);
        }

        $codigo = $this->utilsHelper->generateNumber(5);
        $payload = [
            "email" => $params["email"],
            "codigo" => $codigo
        ];
        $this->jwt->setPayload($payload);
        $jwt = $this->jwt->generateJWT();

        $body = "<p>Olá, {$usuario['nome']}.</p><br><br>
                 <p>Seu código para criar sua nova senha é: <b>{$codigo}</b>.</p>
                 <p>Entre <a href='http://localhost/petlove/sistema/user/changepassword/{$usuario['id']}/{$codigo}'>neste link</a> e siga os passos para criar sua nova senha.</p>";

        $this->email->addAddress($params["email"]);

        try {
            setcookie("forgotpassword", $jwt, (time() + (60 * 10)), "/", "localhost");
            $this->email->send($body, "Crie uma nova senha!");
            $this->response([
                "message" => "Olá, {$usuario['nome']}. Um e-mail foi enviado para {$params['email']}. Siga as instruções para criar uma nova senha",
            ]);
        } catch (\Exception $e) {
            $this->response([
                "message" => "Não foi possível enviar o e-mail com os passos para a nova senha. Tente
                novamente mais tarde!"
            ], HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}