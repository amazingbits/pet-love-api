<?php

namespace App\Controller;

use App\Core\DefaultController;
use App\Helper\DateHelper;
use App\Helper\FileHelper;
use App\Helper\ParamsHelper;
use App\Model\DocumentoDAO\DocumentoDAO;

class DocumentoController extends DefaultController
{
    private DocumentoDAO $documentoDAO;

    public function __construct()
    {
        $this->documentoDAO = new DocumentoDAO();
    }

    public function save()
    {
        $fileName = "";
        if(isset($_FILES["file"])) {

            $fileHelper = new FileHelper();
            $fileHelper->createDirectory();
            $dir = __DIR__ . "/../../public/documentos/";
            $allowedExtensions = ["pdf"];
            $maxSizeAllowed = 2000000;
            $file = $_FILES["file"];

            $explodedName = explode(".", $file["name"]);
            $extension = mb_strtolower($explodedName[count($explodedName) - 1]);

            $imgSize = $file["size"];

            if($imgSize > $maxSizeAllowed) {
                $this->response([
                    "message" => "São permitidos arquivos de até 2mb de tamanho!",
                    "status" => HTTP_BAD_REQUEST
                ], HTTP_BAD_REQUEST);
            }

            if(!in_array($extension, $allowedExtensions)) {
                $this->response([
                    "message" => "A extensão do arquivo precisa ser .pdf",
                    "status" => HTTP_BAD_REQUEST
                ], HTTP_BAD_REQUEST);
            }

            $newName = uniqid() . "." . $extension;
            $fileName = $newName;
            if(!@move_uploaded_file($file["tmp_name"], $dir . $newName)) {
                $this->response([
                    "message" => "Houve um problema para inserir o arquivo PDF. Tente novamente mais tarde!",
                    "status" => HTTP_INTERNAL_SERVER_ERROR
                ], HTTP_INTERNAL_SERVER_ERROR);
            }
        }

        $dateHelper = new DateHelper();
        $dt = [
            "descricao" => trim($_POST['descricao']),
            "data" => $dateHelper->dateBrlToSql($_POST['data']),
            "animal" => (int)$_POST['animal'],
            "notas" => trim($_POST['notas']),
            "file_path" => $fileName
        ];

        if($this->documentoDAO->save($dt)) {
            $this->response([
                "message" => "Registro inserido com sucesso!",
                "status" => HTTP_CREATED
            ]);
        }
        $this->response([
            "message" => "Houve um problema ao inserir o registro. Tente novamente mais tarde.",
            "status" => HTTP_INTERNAL_SERVER_ERROR
        ], HTTP_INTERNAL_SERVER_ERROR);

    }

    public function update($data)
    {
        $documentId = (int)$data["documentId"];
        $document = $this->documentoDAO->selectById($documentId);
        if(empty($document)) {
            $this->response([
                "message" => "Não foi encontrado nenhum documento com este ID",
                "status" => HTTP_NOT_FOUND
            ], HTTP_NOT_FOUND);
        }

        $fileName = "";
        if(isset($_FILES["file"])) {

            $fileHelper = new FileHelper();
            $fileHelper->createDirectory();

            $dir = __DIR__ . "/../../public/documentos/";
            $allowedExtensions = ["pdf"];
            $maxSizeAllowed = 2000000;
            $file = $_FILES["file"];

            $explodedName = explode(".", $file["name"]);
            $extension = mb_strtolower($explodedName[count($explodedName) - 1]);

            $imgSize = $file["size"];

            if($imgSize > $maxSizeAllowed) {
                $this->response([
                    "message" => "São permitidos arquivos de até 2mb de tamanho!",
                    "status" => HTTP_BAD_REQUEST
                ], HTTP_BAD_REQUEST);
            }

            if(!in_array($extension, $allowedExtensions)) {
                $this->response([
                    "message" => "A extensão do arquivo precisa ser .pdf",
                    "status" => HTTP_BAD_REQUEST
                ], HTTP_BAD_REQUEST);
            }

            $newName = uniqid() . "." . $extension;
            $fileName = $newName;
            if(!@move_uploaded_file($file["tmp_name"], $dir . $newName)) {
                $this->response([
                    "message" => "Houve um problema para inserir o arquivo PDF. Tente novamente mais tarde!",
                    "status" => HTTP_INTERNAL_SERVER_ERROR
                ], HTTP_INTERNAL_SERVER_ERROR);
            }
            $fileHelper->deleteFile($document["file_path"]);
        }

        $dateHelper = new DateHelper();
        if(isset($_FILES["file"])) {
            $dt = [
                "descricao" => trim($_POST['descricao']),
                "data" => $dateHelper->dateBrlToSql($_POST['data']),
                "animal" => (int)$_POST['animal'],
                "notas" => trim($_POST['notas']),
                "file_path" => $fileName
            ];
        } else {
            $dt = [
                "descricao" => trim($_POST['descricao']),
                "data" => $dateHelper->dateBrlToSql($_POST['data']),
                "animal" => (int)$_POST['animal'],
                "notas" => trim($_POST['notas'])
            ];
        }

        if($this->documentoDAO->update($dt, ["id" => $documentId])) {
            $this->response([
                "message" => "Registro editado com sucesso!",
                "status" => HTTP_OK
            ]);
        }
        $this->response([
            "message" => "Houve um problema ao editar o registro. Tente novamente mais tarde!",
            "status" => HTTP_INTERNAL_SERVER_ERROR
        ], HTTP_INTERNAL_SERVER_ERROR);
    }

    public function delete($data)
    {
        $id = (int)$data["documentId"];
        $document = $this->documentoDAO->selectById($id);
        if(empty($document)) {
            $this->response([
                "message" => "Não foi encontrado nenhum documento com este ID",
                "status" => HTTP_NOT_FOUND
            ], HTTP_NOT_FOUND);
        }

        $fileHelper = new FileHelper();
        if($this->documentoDAO->delete($id)) {
            $fileHelper->deleteFile($document["file_path"]);
            $this->response([
                "message" => "Registro excluído com sucesso!",
                "status" => HTTP_OK
            ]);
        }
        $this->response([
            "message" => "Houve um problema ao excluir o registro. Tente novamente mais tarde!",
            "status" => HTTP_INTERNAL_SERVER_ERROR
        ], HTTP_INTERNAL_SERVER_ERROR);
    }

    public function getByAnimalId($data)
    {
        $animalId = (int)$data["animalId"];
        $this->response($this->documentoDAO->getByAnimalId($animalId));
    }

    public function getById($data)
    {
        $id = (int)$data["id"];
        $this->response($this->documentoDAO->getById($id));
    }
}