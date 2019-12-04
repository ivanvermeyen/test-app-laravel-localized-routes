<?php

//Auth::routes();

Route::get('/', HomeController::class.'@index')->name('home');
Route::get('/home', DashboardController::class.'@index')->name('dashboard');
