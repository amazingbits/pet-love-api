<?php

namespace App\Controller;

use App\Core\DefaultController;
use App\Helper\ParamsHelper;
use App\Model\AnimalDAO\AnimalDAO;
use App\Model\VacinacaoDAO\VacinacaoDAO;
use App\Model\VacinaDAO\VacinaDAO;

class VacinacaoController extends DefaultController
{
    private ParamsHelper $params;
    private VacinacaoDAO $vacinacaoDAO;
    private VacinaDAO $vacinaDAO;
    private AnimalDAO $animalDAO;

    public function __construct()
    {
        $this->params = new ParamsHelper();
        $this->vacinacaoDAO = new VacinacaoDAO();
        $this->vacinaDAO = new VacinaDAO();
        $this->animalDAO = new AnimalDAO();
    }

    public function all()
    {
        $this->response($this->vacinacaoDAO->selectAll());
    }

    public function getById($data)
    {
        $id = (int)$data["id"];
        $this->response($this->vacinacaoDAO->selectById($id));
    }

    public function save()
    {
        $params = $this->params->getJsonParams();
        $needle = [
            "animal" => "integer",
            "vacina" => "integer",
            "data_aplicacao" => "string"
        ];
        if(!$this->params->validateParams($params, $needle)) {
            $this->response([
                "message" => "Parâmetros insuficientes ou tipos de parâmetros inválidos!"
            ], HTTP_BAD_REQUEST);
        }

        if(empty($this->vacinaDAO->selectById((int)$params["vacina"]))) {
            $this->response([
                "message" => "Não existe vacina com o ID informado"
            ], HTTP_BAD_REQUEST);
        }

        if(empty($this->animalDAO->selectById((int)$params["animal"]))) {
            $this->response([
                "message" => "Não existe animal com o ID informado"
            ], HTTP_BAD_REQUEST);
        }

        if($this->vacinacaoDAO->insert($params)) {
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
            "animal" => "integer",
            "vacina" => "integer",
            "data_aplicacao" => "string"
        ];
        if(!$this->params->validateParams($params, $needle)) {
            $this->response([
                "message" => "Parâmetros insuficientes ou tipos de parâmetros inválidos!"
            ], HTTP_BAD_REQUEST);
        }

        if($this->vacinacaoDAO->update($params, ["id" => $id])) {
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

        if (!$this->vacinacaoDAO->compare(["id" => $id])) {
            $this->response([
                "message" => "Não existe registro com este ID"
            ], HTTP_NOT_FOUND);
        }

        if ($this->vacinacaoDAO->delete($id)) {
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

        if (!$this->vacinacaoDAO->compare(["id" => $id])) {
            $this->response([
                "message" => "Não existe registro com este ID"
            ], HTTP_NOT_FOUND);
        }

        if ($this->vacinacaoDAO->disable($id, $visibility)) {
            $this->response([
                "message" => "Visibilidade do registro alterada com sucesso!"
            ], HTTP_CREATED);
        }

        $this->response([
            "message" => "Erro ao alterar visibilidade do registro!"
        ], HTTP_INTERNAL_SERVER_ERROR);
    }

    public function verificarSeEHoraDeVacinar($data)
    {
        $idAnimal = (int)$data["idAnimal"];
        if($this->vacinacaoDAO->verificarSeEHoraDeVacinar($idAnimal)) {
            $this->response([
                "message" => "Você possui vacinas em atraso!"
            ]);
        }
        $this->response([
            "message" => "Está tudo ok com as vacinas do seu pet!"
        ]);
    }
}