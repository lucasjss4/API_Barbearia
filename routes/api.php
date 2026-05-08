<?php

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

    Route::post("/logout", [loginController::class, 'logout']);
});
