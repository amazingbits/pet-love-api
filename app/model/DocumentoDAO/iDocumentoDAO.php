<?php

namespace App\Model\DocumentoDAO;

use App\Model\BaseDAO\iBaseDAO;

interface iDocumentoDAO extends iBaseDAO
{
    public function save(array $params): bool;

    public function getByAnimalId(int $animalId): array;

    public function getById(int $documentId): array;
}