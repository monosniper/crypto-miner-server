<?php

use App\Models\Session;

Route::get('test/:post', function () {
    return view('test');
})->name('test');


Route::get('test', function () {
    $session = Session::create([
        'user_id' => 1023,
    ]);

    $session->servers()->sync([2]);

    dd($session);
});
