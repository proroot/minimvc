<?php

use Core\Route;

Route::set('GET', '', function()
{
    return 'dd';
    //redirect('https://vk.com');
})->aHome();

Route::group(function()
{
    Route::set('GET', 'test', 'Welcome@index')->aError();

    Route::set('GET', 'test2', 'Welcome@test');

    Route::set('GET', 'test3', 'Test_Test');
});

Route::set('GET', 'errorPage', 'error');
