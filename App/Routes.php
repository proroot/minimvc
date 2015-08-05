<?php

use Core\Route;

Route::set('POST', '', function()
{
    //redirect('https://vk.com');
})->aHome();

Route::group(function()
{
    Route::set('GET', 'test', 'Welcome@test')->aError();

    Route::set('GET', 'test2', 'Welcome');
});

Route::set('GET', 'errorPage', 'error');
