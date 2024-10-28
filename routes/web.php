<?php

use Mvc\Http\Route;
use App\Controllers\AuthController;
use App\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);

Route::get('/signup', [AuthController::class, 'signupForm']);

Route::post('/signup', [AuthController::class, 'signup']);
