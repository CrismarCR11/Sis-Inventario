<?php

namespace App\Http\Controllers\API;

use App\Facades\Company;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $companies = Company::all();
        
        return response()->json([
            'success' => true,
            'data' => CompanyResource::collection($companies),
            'meta' => [
                'total' => $companies->total(),
                'per_page' => $companies->perPage(),
                'current_page' => $companies->currentPage()
            ]
        ]);
    }

    public function store(CompanyRequest $request): JsonResponse
    {
        $company = Company::create($request->validated());
        
        return response()->json([
            'success' => true,
            'message' => 'Empresa creada exitosamente',
            'data' => new CompanyResource($company)
        ], 201);
    }

    public function show(string $uuid): JsonResponse
    {
        $company = Company::find($uuid);
        
        return response()->json([
            'success' => true,
            'data' => new CompanyResource($company)
        ]);
    }

    public function update(CompanyRequest $request, string $uuid): JsonResponse
    {
        $company = Company::update($uuid, $request->validated());
        
        return response()->json([
            'success' => true,
            'message' => 'Empresa actualizada exitosamente',
            'data' => new CompanyResource($company)
        ]);
    }

    public function destroy(string $uuid): JsonResponse
    {
        $company = Company::delete($uuid);
        
        return response()->json([
            'success' => true,
            'message' => 'Empresa eliminada exitosamente'
        ]);
    }

    public function toggleStatus(string $uuid): JsonResponse
    {
        $company = Company::toggleStatus($uuid);
        
        return response()->json([
            'success' => true,
            'message' => $company->activo ? 'Empresa activada' : 'Empresa desactivada',
            'data' => new CompanyResource($company)
        ]);
    }
}