<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Company extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'company.service'; // 👈 Un nombre, no la clase directa
    }
}