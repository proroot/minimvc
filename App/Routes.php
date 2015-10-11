<?php

use Core\Route;

Route::set('GET', '', function() {
    return 'dsfdsf <a href="https://proroot.net">proroot</a> dsgsd';
})->aHome();

Route::set('GET', 'errorPage', 'error');
Route::set('ANY', 'api', 'Api@index');

Route::group(function() {
    Route::set('GET', 'test', 'Welcome@index')->aError();
    Route::set('GET', 'test2', 'Welcome@test');
    Route::set('GET', 'test3', 'Test_Test');
});
