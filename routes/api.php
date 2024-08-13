<?php

// header('Access-Control-Allow-Origin:  *');
// header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
// header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');
// TEMPORARY SOLUTION TO = Access to XMLHttpRequest at 'metalounge' from origin 'metaanimals' has been blocked by CORS policy: No 'Access-Control-Allow-Origin' header is present on the requested resource.
// SOLUTION fixes error on host but shows error on local

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UsersController;
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







Route::middleware('throttle:60,1')->get('/v1/get_user_references', [APIController::class, 'getUserReferences']);


/**
 * Throttle request
 * @param string 'throttle:60
 * @param string 1'
 * @return \Illuminate\Routing\RouteRegistrar
 */
Route::middleware('throttle:60,1')->group(function () {



    /**
     * Valida
     * @param string '/v1/login/validation'
     * @param controller [AuthController::class
     * @param function 'loginValidation']
     * @return \Illuminate\Routing\Route
     */
    Route::post('/v1/login/validation',[AuthController::class,'loginValidation'])->name('login.validation');

    /**
     * Sanctum authentication
     * @param string ['auth:sanctum']
     * @return \Illuminate\Routing\RouteRegistrar
     */
    Route::middleware(['auth:sanctum'])->group(function () {


        /**
         * Version prefix
         * @param string 'v1'
         * @return \Illuminate\Routing\RouteRegistrar
         */
        Route::prefix('v1')->group(function () {

            /**
             * Get all pets
             * @param string '/pets'
             * @param controller [ApiPetsController::class
             * @param fucntion 'getallPets']
             * @return \Illuminate\Routing\Route
             */
            Route::get('/pets', [ApiPetsController::class,'getallPets'])->name('api.pets');

            Route::prefix('users')->group(function () {

                Route::get('/get', [UsersController::class,'get'])->name('api.users.get');
                
            });

        });

    });


});

