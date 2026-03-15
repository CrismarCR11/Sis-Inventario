<?php

namespace App\Services;

use App\Models\Company;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\ValidationException;
use App\Interfaces\CompanyInterface;

class CompanyService
{
    public function __construct(
        protected CompanyInterface $companyRepository
    ) {}

    public function all(): LengthAwarePaginator
    {
        return $this->companyRepository->paginate(15);
    }

    public function find(string $uuid): Company
    {
        $company = $this->companyRepository->find($uuid);
        
        if (!$company) {
            throw ValidationException::withMessages([
                'company' => 'Empresa no encontrada'
            ]);
        }
        
        return $company;
    }

    public function create(array $data): Company
    {
        // Validaciones de negocio
        if (!$this->validateRuc($data['ruc'])) {
            throw ValidationException::withMessages([
                'ruc' => 'El RUC no es válido'
            ]);
        }

        // Verificar duplicados
        if ($this->companyRepository->findByRuc($data['ruc'])) {
            throw ValidationException::withMessages([
                'ruc' => 'Ya existe una empresa con este RUC'
            ]);
        }

        // Configuración por defecto
        $data['configuracion'] = [
            'moneda' => $data['configuracion']['moneda'] ?? 'PEN',
            'pais' => $data['configuracion']['pais'] ?? 'Perú',
            'zona_horaria' => $data['configuracion']['zona_horaria'] ?? 'America/Lima'
        ];

        return $this->companyRepository->create($data);
    }

    public function update(string $uuid, array $data): Company
    {
        $company = $this->find($uuid);
        
        // Si cambia el RUC, validar
        if (isset($data['ruc']) && $data['ruc'] !== $company->ruc) {
            if (!$this->validateRuc($data['ruc'])) {
                throw ValidationException::withMessages([
                    'ruc' => 'El RUC no es válido'
                ]);
            }

            $existing = $this->companyRepository->findByRuc($data['ruc']);
            if ($existing && $existing->uuid !== $uuid) {
                throw ValidationException::withMessages([
                    'ruc' => 'Ya existe otra empresa con este RUC'
                ]);
            }
        }

        return $this->companyRepository->update($uuid, $data);
    }

    public function delete(string $uuid): bool
    {
        $company = $this->find($uuid);
        
        // Verificar si tiene locales asociados
        if ($company->locales()->count() > 0) {
            throw ValidationException::withMessages([
                'company' => 'No se puede eliminar: tiene locales asociados'
            ]);
        }

        return $this->companyRepository->delete($uuid);
    }

    public function toggleStatus(string $uuid): Company
    {
        $company = $this->find($uuid);
        
        if ($company->activo) {
            $this->companyRepository->deactivate($uuid);
        } else {
            $this->companyRepository->activate($uuid);
        }

        return $company->fresh();
    }

    public function validateRuc(string $ruc): bool
    {
        // Validación básica de RUC peruano (11 dígitos)
        return preg_match('/^[0-9]{11}$/', $ruc);
    }
}