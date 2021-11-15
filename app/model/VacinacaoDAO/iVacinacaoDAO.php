<?php

namespace App\Model\VacinacaoDAO;

use App\Model\BaseDAO\iBaseDAO;

interface iVacinacaoDAO extends iBaseDAO {

    public function save(array $params): bool;

    public function delete(int $id): bool;

    public function updateVaccinationDate(int $id, string $newDate): bool;

    public function getByAnimalId(int $animalId): array;

    public function getById(int $id): array;

    public function verifyIfExists(int $vaccine, int $animal): bool;

}