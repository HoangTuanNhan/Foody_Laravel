<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where all API routes are defined.
|
*/





Route::resource('categories', 'categoryAPIController');

Route::resource('foods', 'foodAPIController');

Route::resource('pages', 'pageAPIController');

Route::resource('users', 'userAPIController');