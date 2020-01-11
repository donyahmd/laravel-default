<?php

include_once('setup.php');

Route::middleware(['installed'])->group( function () {
    Route::get('/', 'HomeController@index');
});
