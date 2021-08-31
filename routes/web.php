<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\ExportController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('users', UserController::class);
Route::resource('categories', CategoryController::class);
Route::resource('tags', TagController::class);
Route::post('ajax', [AjaxController::class, 'days']);
Route::get('export', [ExportController::class, 'exportToCSV'])->name('export.exportToCSV');
Route::get('export2', [ExportController::class, 'exportToXML'])->name('export2.exportToXML');