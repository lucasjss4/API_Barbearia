<?php

use App\Http\Controllers\AdmController;
use App\Http\Controllers\agendaController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Rota desprotegida do Sactum
Route::post("/client", [UserController::class, 'store']);

Route::post("/login", [loginController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get("/client", [UserController::class, 'index']);
    Route::get("/client/{id}", [UserController::class, 'show']);
    Route::put("/client/{id}", [UserController::class, 'update']);
    Route::delete("/client/{id}", [UserController::class, 'destroy']);

    Route::post("/admin", [AdmController::class, 'store']);
    Route::get("/admin", [AdmController::class, 'index']);
    Route::get("/admin/{id}", [AdmController::class, 'show']);
    Route::put("/admin/{id}", [AdmController::class, 'update']);
    Route::delete("/admin/{id}", [AdmController::class, 'destroy']);

    // Route::post("/agendamento", [agendaController::class, 'store']);

    Route::post("/logout", [loginController::class, 'logout']);
});


