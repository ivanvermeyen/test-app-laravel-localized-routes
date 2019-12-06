<?php

//Auth::routes();

Route::get('/', HomeController::class.'@index')->name('home');
Route::get('/home', DashboardController::class.'@index')->name('dashboard');

Route::localized(function () {

    Route::get('categories/{category}', CategoriesController::class.'@show')->name('categories.show');
    Route::get('posts/{post}/{slug?}', PostsController::class.'@show')->name('posts.show');

});
