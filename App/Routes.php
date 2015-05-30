<?php

use Core\Route;

Route::set('POST|GET', '', 'Welcome@Test')->aHome();

Route::group(function()
{
    Route::set('GET', 'test', 'Welcome')->aError();

    Route::set('GET', 'test2', 'Welcome');
});

Route::set('GET', 'errorPage', 'Error');
