<?php

use App\Http\Controllers\Api\SiteController;
use App\Http\Controllers\Api\TodoController;
use Illuminate\Support\Facades\Route;

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

Route::middleware('apiauth')->group(function () {
    # Login
    Route::post('/user/login', [SiteController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        # To do Operations
        Route::get('/user/todos', [TodoController::class, 'index']);
        Route::post('/create/todo', [TodoController::class, 'store']);
        Route::get('/todo/{todoId}/view', [TodoController::class, 'view']);

        Route::patch('/todo/{todoId}/update', [TodoController::class, 'todoUpdate']);
        Route::patch('/todo/item/{itemId}/update', [TodoController::class, 'todoItemUpdate']);
        Route::patch('/todo/{todoId}/archieve', [TodoController::class, 'todoArchieve']);
        Route::patch('/todo/{todoId}/unarchieve', [TodoController::class, 'todoUnarchieve']);
        Route::patch('/todo/item/{itemId}/mark-complete', [TodoController::class, 'todoItemComplete']);
        Route::delete('/todo/{todoId}/delete', [TodoController::class, 'todoDelete']);
        Route::delete('/todo/item/{itemId}/delete', [TodoController::class, 'todoItemDelete']);

        # Logout
        Route::get('/user/logout', [SiteController::class, 'logout']);
    });
});
