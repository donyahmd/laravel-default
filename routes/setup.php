<?php

/*
|--------------------------------------------------------------------------
| Setup Web Routes
|--------------------------------------------------------------------------
*/

Route::prefix('setup')->group( function () {
    Route::get('', 'SetupController@viewSetup');
    Route::post('', 'SetupController@setup');
});
