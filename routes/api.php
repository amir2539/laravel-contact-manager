<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactNoteController;
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

Route::prefix('auth')
    ->middleware('guest')
    ->group(function () {
        Route::post('/login', LoginController::class)->name('login');
        Route::post('/register', RegisterController::class);
    });

Route::middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('contacts', ContactController::class);
        Route::prefix('contacts')
            ->group(function () {
                Route::post('/{contact}/note', [ContactNoteController::class, 'store']);
                Route::delete('/note/{note}', [ContactNoteController::class, 'destroy']);
            });

        Route::prefix('companies')
            ->group(function () {
                Route::get('/', [CompanyController::class, 'index']);
                Route::get('/{company}/contacts', [CompanyController::class, 'contacts']);
            });
    });
