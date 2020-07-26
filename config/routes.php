<?php

use FTPApp\Routing\Route;
use FTPApp\Controllers\Home\HomeController;
use FTPApp\Controllers\Filemanager\FilemanagerController;

return [

    Route::get('/', [HomeController::class, 'index']),

    Route::get('/api/rename?old=:s&new=:s', [FilemanagerController::class, 'getFiles']),

];