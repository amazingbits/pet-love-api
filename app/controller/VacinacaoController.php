<?php

namespace App\Controller;

use App\Core\DefaultController;
use App\Helper\DateHelper;
use App\Helper\FileHelper;
use App\Helper\ParamsHelper;
use App\Model\AnimalDAO\AnimalDAO;
use App\Model\VacinacaoDAO\VacinacaoDAO;
use App\Model\VacinaDAO\VacinaDAO;

class VacinacaoController extends DefaultController
{
    private VacinacaoDAO $vacinacaoDAO;
    private VacinaDAO $vacinaDAO;
    private AnimalDAO $animalDAO;

    private FileHelper $fileHelper;
    private DateHelper $dateHelper;
    private ParamsHelper $params;

    public function __construct()
    {
        $this->fileHelper = new FileHelper();
        $this->dateHelper = new DateHelper();
        $this->params = new ParamsHelper();

        $this->vacinacaoDAO = new VacinacaoDAO();
        $this->vacinaDAO = new VacinaDAO();
        $this->animalDAO = new AnimalDAO();
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

        if(!$this->dateHelper->isSqlDate($params["data_aplicacao"])) {
            $this->response([
                "message" => "Insira uma data de aplicação válida!",
                "status" => HTTP_BAD_REQUEST
            ], HTTP_BAD_REQUEST);
        }

        if(empty($this->vacinaDAO->selectById((int)$params["vacina"]))) {
            $this->response([
                "message" => "Vacina não encontrada!",
                "status" => HTTP_BAD_REQUEST
            ], HTTP_BAD_REQUEST);
        }

        if(empty($this->animalDAO->selectById((int)$params["animal"]))) {
            $this->response([
                "message" => "Animal não encontrado!",
                "status" => HTTP_BAD_REQUEST
            ], HTTP_BAD_REQUEST);
        }

//        if(!$this->dateHelper->isBigger($params["data_aplicacao"], date("Y-m-d"))) {
//            $this->response([
//                "message" => "A data de aplicação deve ser superior à data de hoje!",
//                "status" => HTTP_BAD_REQUEST
//            ], HTTP_BAD_REQUEST);
//        }

        if($this->vacinacaoDAO->verifyIfExists((int)$params["vacina"], (int)$params["animal"])) {
           $this->response([
               "message" => "Já existe um cadastro desta vacina para este animal!",
               "status" => HTTP_BAD_REQUEST
           ], HTTP_BAD_REQUEST);
        }

        if($this->vacinacaoDAO->save($params)) {
            $this->response([
                "message" => "Registro inserido com sucesso!",
                "status" => HTTP_CREATED
            ]);
        }
        $this->response([
            "message" => "Erro ao inserir registro. Tente novamente mais tarde!",
            "status" => HTTP_INTERNAL_SERVER_ERROR
        ], HTTP_INTERNAL_SERVER_ERROR);
    }

    public function delete($data)
    {
        $id = (int)$data["id"];
        if(empty($this->vacinacaoDAO->selectById($id))) {
            $this->response([
                "message" => "Vacinação não encontrada!",
                "status" => HTTP_NOT_FOUND
            ], HTTP_NOT_FOUND);
        }

        if($this->vacinacaoDAO->delete($id)) {
            $this->response([
                "message" => "Registro deletado com sucesso!",
                "status" => HTTP_OK
            ]);
        }
        $this->response([
            "message" => "Houve um problema ao deletar o registro. Tente novamente mais tarde!",
            "status" => HTTP_INTERNAL_SERVER_ERROR
        ], HTTP_INTERNAL_SERVER_ERROR);
    }

    public function update($data)
    {
        $id = (int)$data["id"];
        $params = $this->params->getJsonParams();
        $needle = [
            "data_aplicacao" => "string"
        ];
        if(!$this->params->validateParams($params, $needle)) {
            $this->response([
                "message" => "Parâmetros insuficientes ou tipos de parâmetros inválidos!"
            ], HTTP_BAD_REQUEST);
        }

        if(empty($this->vacinacaoDAO->selectById($id))) {
            $this->response([
                "message" => "Vacinação não encontrada!",
                "status" => HTTP_NOT_FOUND
            ], HTTP_NOT_FOUND);
        }

//        if(!$this->dateHelper->isBigger($params["data_aplicacao"], date("Y-m-d"))) {
//            $this->response([
//                "message" => "A data de aplicação deve ser superior à de hoje!",
//                "status" => HTTP_BAD_REQUEST
//            ], HTTP_BAD_REQUEST);
//        }

        if($this->vacinacaoDAO->update($params, ["id" => $id])) {
            $this->response([
                "message" => "Registro atualizado com sucesso!",
                "status" => HTTP_OK
            ]);
        }
        $this->response([
            "message" => "Houve um problema ao atualizar o registro. Tente novamente mais tarde!",
            "status" => HTTP_INTERNAL_SERVER_ERROR
        ], HTTP_INTERNAL_SERVER_ERROR);
    }

    public function getByAnimalId($data)
    {
        $animalId = (int)$data["animalId"];
        $this->response($this->vacinacaoDAO->getByAnimalId($animalId));
    }

    public function getById($data)
    {
        $id = (int)$data["id"];
        $this->response($this->vacinacaoDAO->getById($id));
    }
}