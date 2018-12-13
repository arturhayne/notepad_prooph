<?php

use Illuminate\Http\Request;

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

Route::get('notepad/{id}/note', [\App\Http\Controllers\AddNoteController::class, 'store']);
Route::get('notepad', [\App\Http\Controllers\AddNotepadController::class, 'store']);
Route::get('user', [\App\Http\Controllers\AddUserController::class, 'store']);
Route::get('notepad/{id}', [\App\Http\Controllers\RetrieveNotepadController::class, 'show']);

