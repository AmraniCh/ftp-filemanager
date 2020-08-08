<?php

use FTPApp\Controllers\Filemanager\FilemanagerController;
use FTPApp\Controllers\Login\LoginController;
use FTPApp\Routing\Route;
use FTPApp\Controllers\Home\HomeController;

return [

    Route::get('/', [HomeController::class, 'index'], 'home'),
    Route::get('/login', [LoginController::class, 'index'], 'login'),
    Route::post('/login', [LoginController::class, 'login']),
    Route::get('/filemanager', [FilemanagerController::class, 'index'], 'filemanager'),

    /**
     * Api routing
     */
    Route::get('/api?action=browse&path=:encoded', [FilemanagerController::class, 'browse']),
    Route::post('/api?action=addFile', [FilemanagerController::class, 'addFile']),
    Route::post('/api?action=addFolder', [FilemanagerController::class, 'addFolder']),

];
