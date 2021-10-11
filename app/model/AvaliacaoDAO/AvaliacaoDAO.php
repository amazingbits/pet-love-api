<?php

namespace App\Model\AvaliacaoDAO;

use App\Core\Connection;
use App\Model\BaseDAO\BaseDAO;

class AvaliacaoDAO extends BaseDAO implements iAvaliacaoDAO
{
    public function __construct()
    {
        $this->setTable("avaliacao");
    }

    public function getByUser(int $idUser): array
    {
        $sqlQuery = "SELECT avaliacao.id AS id,
                            empresa.nome AS empresa,
                            usuario.nome AS usuario,
                            avaliacao.nota AS nota,
                            avaliacao.descricao AS descricao,
                            avaliacao.criado_em AS criado_em,
                            avaliacao.ativo AS ativo
                     FROM avaliacao
                     INNER JOIN usuario AS empresa ON (avaliacao.empresa = empresa.id) 
                     INNER JOIN usuario ON (avaliacao.usuario = usuario.id)
                     WHERE avaliacao.empresa = :id";
        try {
            $conn = Connection::getInstance();
            $stmt = $conn->prepare($sqlQuery);
            $stmt->bindValue(":id", $idUser);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            return [];
        }
    }
}