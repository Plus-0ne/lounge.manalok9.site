<?php

// header('Access-Control-Allow-Origin:  *');
// header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
// header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');
// TEMPORARY SOLUTION TO = Access to XMLHttpRequest at 'metalounge' from origin 'metaanimals' has been blocked by CORS policy: No 'Access-Control-Allow-Origin' header is present on the requested resource.
// SOLUTION fixes error on host but shows error on local

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\APIController;
use App\Http\Controllers\User\ApiPetsController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('throttle:60,1')->get('/v1/get_user_references', [APIController::class, 'getUserReferences']);

/* -------------------------------------------------------------------------- */
/*                           Pet REST API endpoints                           */
/* -------------------------------------------------------------------------- */
Route::middleware('throttle:60,1')->group(function () {
    Route::get('/v1/pets', [ApiPetsController::class,'getallPets'])->name('api.pets');
});

