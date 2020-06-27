<?php
use \Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'api.doc'], function () {
    Route::get('/api-doc', function () {
        return view('document::api');
    });
});
