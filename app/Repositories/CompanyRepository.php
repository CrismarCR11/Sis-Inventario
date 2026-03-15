<?php

namespace App\Repositories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Interfaces\CompanyInterface;

class CompanyRepository implements CompanyInterface
{
    public function __construct(
        protected Company $model
    ) {}

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->paginate($perPage);
    }

    public function find(string $uuid): ?Company
    {
        return $this->model->where('uuid', $uuid)->first();
    }

    public function findByRuc(string $ruc): ?Company
    {
        return $this->model->where('ruc', $ruc)->first();
    }

    public function create(array $data): Company
    {
        return $this->model->create($data);
    }

    public function update(string $uuid, array $data): Company
    {
        $company = $this->find($uuid);
        $company->update($data);
        return $company->fresh();
    }

    public function delete(string $uuid): bool
    {
        $company = $this->find($uuid);
        return $company ? $company->delete() : false;
    }

    public function activate(string $uuid): bool
    {
        $company = $this->find($uuid);
        return $company ? $company->update(['activo' => true]) : false;
    }

    public function deactivate(string $uuid): bool
    {
        $company = $this->find($uuid);
        return $company ? $company->update(['activo' => false]) : false;
    }
}
