<?php

/*
|--------------------------------------------------------------------------
| Setup Web Routes
|--------------------------------------------------------------------------
*/

Route::prefix('setup')->group( function () {
    Route::get('', 'SetupController@viewSetup');
    Route::get('/run-migrate', 'SetupController@runMigrate');
    Route::post('', 'SetupController@setup');
});
