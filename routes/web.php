<?php

use App\Models\Session;

Route::get('test/:post', function () {
    return view('test');
})->name('test');


Route::get('test', function () {
    dd(Session::with('servers')->get());
});
