<?php

declare(strict_types=1);

use App\Http\Controllers\Api\TenantController;
use App\Http\Controllers\Tenant\Api\AuthController;
use App\Http\Controllers\Tenant\Api\TeacherController;
use App\Models\Tenant\Config;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'api',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', function () {
        $appName = Config::find('APP_NAME');
        return $appName->value;
        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    });

    Route::prefix('/api')->group(function () {

        Route::prefix('auth')->group(function () {
            Route::post('/login', [AuthController::class, 'login']);
            Route::get('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');
        });

        Route::prefix('teacher')->group(function () {
            Route::get('/', [TeacherController::class, 'index']);
            Route::post('/', [TeacherController::class, 'store']);
        });
    });
});
