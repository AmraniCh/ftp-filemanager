<?php

use FTPApp\Controllers\Filemanager\FilemanagerController;
use FTPApp\Routing\Route;
use FTPApp\Controllers\Home\HomeController;

return [

    Route::get('/', [HomeController::class, 'index'], 'home'),

    Route::get('/filemanager', [FilemanagerController::class, 'index'], 'filemanager'),

];