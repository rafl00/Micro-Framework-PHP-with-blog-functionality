<?php

declare(strict_types = 1);

namespace App\Repositories\Contracts;

use App\DataObjects\DataTableParametersDto;

interface BlogRepositoryInterface
{
    public function getAll(): array;

    public function create(string $text): bool;

    public function getPaginated(DataTableParametersDto $params): array;

    public function count(): int;

    public function delete(int $id): bool;

    public function isAuthor(int $blogId): bool;
}
