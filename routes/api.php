<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Admin\LoginController;
use App\Http\Controllers\Api\Admin\PlaceController;
use App\Http\Controllers\Api\Admin\LogoutController;
use App\Http\Controllers\Api\Admin\SliderController;
use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\Web\CategoryController as web_CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


//group route with prefix "admin"
Route::prefix('admin')->group(function () {

    //route login
    Route::post('/login', LoginController::class, ['as' => 'admin']);

    //group route with middleware "auth:api"
    Route::group(['middleware' => 'auth:api'], function () {

        //route user logged in
        Route::get('/user', function (Request $request) {
            return $request->user();
        })->name('user');

        //route logout
        Route::post('/logout', LogoutController::class, ['as' => 'admin']);

        //route dashboard
        Route::get('/dashboard', DashboardController::class, ['as' => 'admin']);

        //categories resource
        Route::apiResource('/categories', CategoryController::class, ['except' => ['create', 'edit'], 'as' => 'admin']);

        //places resource
        Route::apiResource('/places', PlaceController::class, ['except' => ['create', 'edit'], 'as' => 'admin']);

        //sliders resource
        Route::apiResource('/sliders', SliderController::class, ['except' => ['create', 'show', 'edit', 'update'], 'as' => 'admin']);

        //users resource
        Route::apiResource('/users', UserController::class, ['except' => ['create', 'edit'], 'as' => 'admin']);
    });
});

//group route with prefix "web"
Route::prefix('web')->group(function () {

    //route categories index
    Route::get('/categories', [web_CategoryController::class, 'index', ['as' => 'web']]);

    //route categories show
    Route::get('/categories/{slug?}', [web_CategoryController::class, 'show', ['as' => 'web']]);

    //route places index
    Route::get('/places', [App\Http\Controllers\Api\Web\PlaceController::class, 'index', ['as' => 'web']]);

    //route places show
    Route::get('/places/{slug?}', [App\Http\Controllers\Api\Web\PlaceController::class, 'show', ['as' => 'web']]);

    //route all places index
    Route::get('/all_places', [App\Http\Controllers\Api\Web\PlaceController::class, 'all_places', ['as' => 'web']]);

    //route sliders
    Route::get('/sliders', [App\Http\Controllers\Api\Web\SliderController::class, 'index', ['as' => 'web']]);
});
