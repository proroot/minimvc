<?php

use Core\Route;

Route::set('POST', '', function()
{
    $uRequest = Core\Request::getInstance();

    return $uRequest->host();
})->aHome();

Route::group(function()
{
    Route::set('GET', 'test', 'welcome@test3')->aError();

    Route::set('GET', 'test2', 'welcome');
});

Route::set('GET', 'errorPage', 'error');
