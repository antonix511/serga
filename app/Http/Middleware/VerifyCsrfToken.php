<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    protected $except = [
        '/ajax/proyecto',
        '/ajax/seguimiento-proyecto',
        '/ajax/actainicio',
        '/ajax/centro',
        '/ajax/matrizcomuinicio',
        '/ajax/matrizrolesinicio',
        '/ajax/reqlogisinicio',
        '/ajax/reqcartinicio',
        '/ajax/matrizriesgos',
        '/ajax/reporteho',
        '/ajax/solicitudac',
        '/ajax/seguimiento-proyecto-filter',
        '/ajax/historial-seguimiento/*'
    ];
}
