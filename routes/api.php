<?php

use App\Http\Controllers\Product\CreateProductController;
use App\Http\Controllers\Product\DetailsProductController;
use App\Http\Controllers\Product\DeleteProductController;
use App\Http\Controllers\Product\UpdateProductController;
use App\Http\Controllers\Product\SearchProductController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::name('product.')->prefix('product')->group(function () {
    //Route::get('/{product}', DetailsProductController::class)->name('details');
    Route::get('/busca', SearchProductController::class)->name('search');
    Route::post('/create', CreateProductController::class)->name('create');
    Route::patch('/{product}', UpdateProductController::class)->name('update');
    Route::delete('/{product}', DeleteProductController::class)->name('delete');
});
