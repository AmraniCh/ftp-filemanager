<?php

use FTPApp\Routing\Route;
use FTPApp\Controllers\Home\HomeController;

return [

    Route::get('/', [HomeController::class, 'index']),

    //Route::get('/api/rename?old=:s&new=:s', [FilemanagerController::class, 'getFiles']),

];