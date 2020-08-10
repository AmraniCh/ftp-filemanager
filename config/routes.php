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
    Route::get('/api?action=getFileContent&file=:encoded', [FilemanagerController::class, 'getFileContent']),
    Route::put('/api?action=updateFileContent', [FilemanagerController::class, 'updateFileContent']),
    Route::delete('/api?action=remove', [FilemanagerController::class, 'remove']),
    Route::put('/api?action=rename', [FilemanagerController::class, 'rename']),
    Route::get('/api?action=getDirectoryTree', [FilemanagerController::class, 'getDirectoryTree']),
    Route::put('/api?action=move', [FilemanagerController::class, 'move']),
    Route::put('/api?action=permissions', [FilemanagerController::class, 'permissions']),

];
