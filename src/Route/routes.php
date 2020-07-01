<?php
use \Illuminate\Support\Facades\Route;

Route::get('/apidoc', ['uses' => '\Pucoder\Apidoc\Controller\ApiDocController@index', 'as' => 'apidoc.index']);
