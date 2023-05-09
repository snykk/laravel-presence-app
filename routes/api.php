<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix("/auth")->group(function () {
    Route::post("/login", "AuthController@login");
    Route::post("/logout", "AuthController@logout")->middleware("auth:sanctum");
  });
  

Route::middleware('auth:web')->group(static function () {
    Route::apiResource('/admins', 'AdminsController')->only(['index', 'show']);
    Route::apiResource('/permissions', 'PermissionsController')->only(['index', 'show']);
    Route::apiResource('/roles', 'RolesController')->only(['index', 'show']);
});

Route::apiResource('/settings', 'SettingsController')->only(['index', 'show']);
Route::apiResource('/seo_metas', 'SeoMetasController')->only(['index', 'show']);

Route::prefix('{locale}')->middleware(['check.locale'])->group(function () {
    Route::apiResource('/components', 'ComponentsController')->only(['index', 'show']);
    Route::apiResource('/departments', 'DepartmentsController')->only(['index', 'show']);
});
