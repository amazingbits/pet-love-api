<?php

namespace App\Model\BaseDAO;

interface iBaseDAO
{
    public function selectAll(
        string $orderColumn = "id",
        string $orderDirection = "ASC",
        int $limit = null,
        int $offset = 0,
        bool $getJustActiveElements = true
    ): array;

    public function selectById(int $id): array;

    public function insert(array $data): bool;

    public function update(array $data, array $where): bool;

    public function delete(int $id): bool;

    public function disable(int $id, int $status): bool;

    public function compare(array $params, string $compareType, bool $removeItem, array $itemsToRemove): bool;

    public function getLastId(): int;
}