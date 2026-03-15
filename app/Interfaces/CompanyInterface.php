<?php

namespace App\Interfaces;

use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface CompanyInterface
{
    public function all(): Collection;
    public function paginate(int $perPage = 15): LengthAwarePaginator;
    public function find(string $uuid): ?Company;
    public function findByRuc(string $ruc): ?Company;
    public function create(array $data): Company;
    public function update(string $uuid, array $data): Company;
    public function delete(string $uuid): bool;
    public function deactivate(string $uuid): bool;
    public function activate(string $uuid): bool;
}