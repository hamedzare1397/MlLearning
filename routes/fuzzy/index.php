<?php


use \Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ML\Fuzzy\IndexController;
use \App\Http\Controllers\ML\Fuzzy\MamdaniController;

Route::get('', [IndexController::class, 'index',])->name('.index');
Route::get('learn', [IndexController::class, 'learn',])->name('.learn');
Route::get('predict', [IndexController::class, 'predict',])->name('.predict');


Route::get('mamdani', [IndexController::class, 'mamdani',])->name('.mamdani');

Route::prefix('new_mamdani')
    ->name('.new_mamdani')
    ->group(function () {
        Route::get('train', [MamdaniController::class, 'train'])->name('.train');
        Route::get('predict', [MamdaniController::class, 'predict'])->name('.predict');
    });

