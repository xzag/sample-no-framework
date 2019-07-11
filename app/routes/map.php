<?php

use app\core\Route;

Route::any('/auth/login', \app\controllers\AuthController::class, 'login');
Route::post('/auth/logout', \app\controllers\AuthController::class, 'logout');
Route::any('/auth/signup', \app\controllers\AuthController::class, 'signup');
Route::get('/', \app\controllers\SiteController::class, 'index');
Route::any('/user/profile', \app\controllers\UserController::class, 'profile');