<?php


Route::get('test/:post', function () {
    return view('test');
})->name('test');


Route::get('test', function () {
    dd(Lang::get());
});
