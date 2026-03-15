<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Local;
use App\Models\Product;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
     public function run(): void
    {
        // Crear empresa demo
        $empresa = Company::create([
            'uuid' => \Illuminate\Support\Str::uuid(),
            'ruc' => '12345678901',
            'razon_social' => 'Demo S.A.C.',
            'nombre_comercial' => 'Mi Inventario',
            'email' => 'info@demo.com',
            'telefono' => '987654321',
            'direccion' => 'Av. Siempre Viva 123',
            'configuracion' => ['moneda' => 'PEN', 'pais' => 'Perú']
        ]);
        
        // Crear local principal
        $local = Local::create([
            'uuid' => \Illuminate\Support\Str::uuid(),
            'empresa_id' => $empresa->id,
            'codigo' => 'LOCAL001',
            'nombre' => 'Local Principal',
            'tipo' => 'principal',
            'ciudad' => 'Lima',
            'email' => '01@gmail.com',
            'activo' => true
        ]);
        
        // Crear categorías
        $electronica = Category::create([
            'empresa_id' => $empresa->id,
            'nombre' => 'Electrónica',
            'slug' => 'electronica'
        ]);
        
        // Crear productos
        $producto = Product::create([
            'uuid' => \Illuminate\Support\Str::uuid(),
            'empresa_id' => $empresa->id,
            'categoria_id' => $electronica->id,
            'sku' => 'PROD001',
            'nombre' => 'Laptop Demo',
            'precio_compra' => 2500.00,
            'precio_venta' => 3200.00,
            'stock_minimo' => 5
        ]);
        
        // Crear inventario inicial
        $producto->inventories()->create([
            'local_id' => $local->id,
            'stock_actual' => 10
        ]);
        
        // Crear usuario admin
        User::create([
            'empresa_id' => $empresa->id,
            'name' => 'Admin',
            'email' => 'admin@demo.com',
            'password' => bcrypt('password'),
            'locales_acceso' => [$local->id]
        ]);
    }
}
