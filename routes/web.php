<?php

use App\Http\Controllers\Api\V1\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('test/:post', function () {
    return view('test');
})->name('test');
