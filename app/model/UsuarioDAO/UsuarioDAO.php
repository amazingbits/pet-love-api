<?php

namespace App\Model\UsuarioDAO;

use App\Core\Connection;
use App\Model\AnimalDAO\AnimalDAO;
use App\Model\BaseDAO\BaseDAO;
use App\Model\EnderecoDAO\EnderecoDAO;

class UsuarioDAO extends BaseDAO implements iUsuarioDAO
{
    private EnderecoDAO $enderecoDAO;
    private AnimalDAO $animalDAO;

    public function __construct()
    {
        $this->setTable("usuario");
        $this->enderecoDAO = new EnderecoDAO();
        $this->animalDAO = new AnimalDAO();
    }

    public function pegarUsuarioComEnderecoEAnimais(
        string $orderColumn = "id",
        string $orderDirection = "ASC",
        int $limit = null,
        int $offset = 0,
        bool $getJustActiveElements = true
    ): array
    {
        $res = [];
        $usuarios = $this->selectAll($orderColumn, $orderDirection, $limit, $offset, $getJustActiveElements);
        foreach($usuarios as $key=>$value) {
            $usuarioId = (int)$value["id"];
            $animais = $this->animalDAO->pegarAnimalPorIdDeUsuario($usuarioId);
            $enderecos = $this->enderecoDAO->pegarEnderecoPorIdDeUsuario($usuarioId);
            $curr = $value;
            $curr["animais"] = $animais;
            $curr["enderecos"] = $enderecos;
            array_push($res, $curr);
        }
        return $res;
    }

    public function getByEmail(string $email): array
    {
        $sqlQuery = "SELECT * FROM usuario WHERE email = :email";
        try {
            $conn = Connection::getInstance();
            $stmt = $conn->prepare($sqlQuery);
            $stmt->bindValue(":email", $email);
            $stmt->execute();
            if($stmt->rowCount() > 0) return $stmt->fetch();
            return [];
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function changePassword(int $id, string $password): bool
    {
        $sqlQuery = "UPDATE usuario SET senha = :password WHERE id = :id";
        try {
            $conn = Connection::getInstance();
            $stmt = $conn->prepare($sqlQuery);
            $stmt->bindValue(":password", $password);
            $stmt->bindValue(":id", $id);
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function pesquisarEmpresasPorRaio(float $latitude, float $longitude): array
    {
        $sqlQuery = "
            SELECT 	endereco.*,
                    usuario.*,
                    (6371 *
                    acos(
                        cos(radians(:latitude)) *
                        cos(radians(latitude)) *
                        cos(radians(:longitude) - radians(longitude)) +
                        sin(radians(:latitude)) *
                        sin(radians(latitude))
                    )) AS raio
            FROM endereco
            INNER JOIN usuario ON
            (endereco.usuario = usuario.id)
            HAVING raio <= 5 AND tipo_usuario = 2;
        ";
        try {
            $conn = Connection::getInstance();
            $stmt = $conn->prepare($sqlQuery);
            $stmt->bindValue(":latitude", $latitude);
            $stmt->bindValue(":longitude", $longitude);
            $stmt->execute();
            $res = [];
            foreach($stmt->fetchAll() as $item) {
                $phone = $item["telefone"];
                $curr = [
                    "id" => $item["id"],
                    "name" => $item["nome"],
                    "phone" => "(" . substr($phone, 0, 2) . ") " . substr($phone, 2, 9),
                    "photo" => $item["path_url"],
                    "street" => $item["rua"],
                    "number" => $item["numero"]
                ];
                array_push($res, $curr);
            }
            return $res;
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function loginByApp(string $email, string $senha): array
    {
        $sqlQuery = "SELECT * FROM usuario WHERE email = :email AND senha = :senha AND tipo_usuario = 1";
        try {
            $conn = Connection::getInstance();
            $stmt = $conn->prepare($sqlQuery);
            $stmt->bindValue(":email", $email);
            $stmt->bindValue(":senha", $senha);
            $stmt->execute();
            if($stmt->rowCount() > 0) return $stmt->fetch();
            return [];
        } catch(\PDOException $e) {
            return [];
        }
    }

    public function newUserByApp(array $newUserProps): bool
    {
        $sqlQuery = "INSERT INTO usuario (nome, email, telefone, path_url, senha, tipo_usuario) VALUES (:nome, :email, :telefone, :path_url, :senha, :tipo_usuario)";
        try {
            $conn = Connection::getInstance();
            $stmt = $conn->prepare($sqlQuery);
            $stmt->bindValue(":nome", $newUserProps["name"]);
            $stmt->bindValue(":email", $newUserProps["email"]);
            $stmt->bindValue(":telefone", $newUserProps["phone"]);
            $stmt->bindValue(":path_url", $newUserProps["path_url"]);
            $stmt->bindValue(":senha", $newUserProps["password"]);
            $stmt->bindValue(":tipo_usuario", $newUserProps["user_type"]);
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function findCompaniesByName(string $name): array
    {
        $sqlQuery = "SELECT usuario.*, endereco.rua AS rua, endereco.numero AS numero FROM usuario INNER JOIN endereco ON (endereco.usuario = usuario.id) ";
        if(strlen(trim($name)) > 0) {
            $sqlQuery .= " WHERE nome LIKE :nome AND tipo_usuario = 2 ORDER BY nome ASC";
        } else {
            $sqlQuery .= " WHERE tipo_usuario = 2 ORDER BY nome ASC ";
        }

        try {
            $conn = Connection::getInstance();
            $stmt = $conn->prepare($sqlQuery);
            if(strlen(trim($name)) > 0) {
                $stmt->bindValue(":nome", "%" . $name . "%");
            }
            $stmt->execute();
            $res = [];
            foreach($stmt->fetchAll() as $item) {
                $phone = $item["telefone"];
                $curr = [
                    "id" => $item["id"],
                    "name" => $item["nome"],
                    "phone" => "(" . substr($phone,0,2) . ") " . substr($phone, 2,9),
                    "photo" => $item["path_url"],
                    "street" => $item["rua"],
                    "number" => $item["numero"]
                ];
                array_push($res, $curr);
            }
            return $res;

        } catch (\PDOException $e) {
            return [];
        }
    }
}