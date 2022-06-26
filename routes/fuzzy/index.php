<?php


use \Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ML\Fuzzy\IndexController;

Route::get('', [IndexController::class, 'index',])->name('.index');
Route::get('learn', [IndexController::class, 'learn',])->name('.learn');
Route::get('predict', [IndexController::class, 'predict',])->name('.predict');
