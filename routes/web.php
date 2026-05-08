<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get("/user/{id}", [UserController::class, 'getUser']);
