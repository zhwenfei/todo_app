<?php

use App\Http\Controllers\TodoAppController;
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

Route::middleware(['auth:sanctum'])->group(function () {
    Route::controller(TodoAppController::class)->group(function () {
        Route::get('/todo/get', 'get')->name('todo.get');
        Route::get('/todo/list', 'list')->name('todo.list');
        Route::post('/todo/create', 'create')->name('todo.create');
        Route::post('/todo/update', 'update')->name('todo.update');
        Route::delete('/todo/delete', 'delete')->name('todo.delete');
    });
});
