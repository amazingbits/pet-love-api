<?php

namespace App\Controller;

use App\Core\DefaultController;
use App\Helper\ParamsHelper;
use App\Model\AnimalComportamentoDAO\AnimalComportamentoDAO;

class AnimalComportamentoController extends DefaultController
{
    private ParamsHelper $params;
    private AnimalComportamentoDAO $animalComportamentoDAO;

    public function __construct()
    {
        $this->params = new ParamsHelper();
        $this->animalComportamentoDAO = new AnimalComportamentoDAO();
    }

    public function all()
    {
        $this->response($this->animalComportamentoDAO->selectAll());
    }

    public function getById($data = [])
    {
        $id = (int)$data["id"];
        $this->response($this->animalComportamentoDAO->selectById($id));
    }

    public function save()
    {
        $params = $this->params->getJsonParams();
        if (!isset($params["descricao"])) {
            $this->response([
                "message" => "Parâmetros insuficientes!"
            ], HTTP_BAD_REQUEST);
        }

        $descricao = filter_var(trim($params["descricao"]), FILTER_SANITIZE_STRING);

        if (mb_strlen($descricao) === 0) {
            $this->response([
                "message" => "O campo DESCRIÇÃO não pode ser vazio!"
            ], HTTP_BAD_REQUEST);
        }

        $data = [
            "descricao" => $descricao
        ];

        if ($this->animalComportamentoDAO->compare($data)) {
            $this->response([
                "message" => "Este registro já existe no banco de dados!",
            ], HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($this->animalComportamentoDAO->insert($data)) {
            $this->response([
                "message" => "Registro inserido com sucesso!"
            ], HTTP_CREATED);
        }

        $this->response([
            "message" => "Erro ao inserir registro!"
        ], HTTP_INTERNAL_SERVER_ERROR);
    }

    public function update($data = [])
    {
        $id = (int)$data["id"];
        $params = $this->params->getJsonParams();

        if (!isset($params["descricao"])) {
            $this->response([
                "message" => "Parâmetros insuficientes!"
            ], HTTP_BAD_REQUEST);
        }

        $descricao = filter_var(trim($params["descricao"]), FILTER_SANITIZE_STRING);

        if (mb_strlen($descricao) === 0) {
            $this->response([
                "message" => "O campo DESCRIÇÃO não pode ser vazio!"
            ], HTTP_BAD_REQUEST);
        }

        $data = [
            "descricao" => $descricao
        ];

        $registro = $this->animalComportamentoDAO->selectById($id);
        $descricaoAtual = $registro["descricao"];
        if ($this->animalComportamentoDAO->compare($data, "=", true, ["descricao" => $descricaoAtual])) {
            $this->response([
                "message" => "Este registro já existe no banco de dados!"
            ], HTTP_INTERNAL_SERVER_ERROR);
        }

        if (!$this->animalComportamentoDAO->compare(["id" => $id])) {
            $this->response([
                "message" => "Não existe registro com este ID"
            ], HTTP_NOT_FOUND);
        }

        if ($this->animalComportamentoDAO->update($data, ["id" => $id])) {
            $this->response([
                "message" => "Registro atualizado com sucesso!"
            ], HTTP_CREATED);
        }

        $this->response([
            "message" => "Erro ao atualizar registro!"
        ], HTTP_INTERNAL_SERVER_ERROR);
    }

    public function delete($data = [])
    {
        $id = (int)$data["id"];

        if (!$this->animalComportamentoDAO->compare(["id" => $id])) {
            $this->response([
                "message" => "Não existe registro com este ID"
            ], HTTP_NOT_FOUND);
        }

        if ($this->animalComportamentoDAO->delete($id)) {
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

        if (!$this->animalComportamentoDAO->compare(["id" => $id])) {
            $this->response([
                "message" => "Não existe registro com este ID"
            ], HTTP_NOT_FOUND);
        }

        if ($this->animalComportamentoDAO->disable($id, $visibility)) {
            $this->response([
                "message" => "Visibilidade do registro alterada com sucesso!"
            ], HTTP_CREATED);
        }

        $this->response([
            "message" => "Erro ao alterar visibilidade do registro!"
        ], HTTP_INTERNAL_SERVER_ERROR);
    }
}