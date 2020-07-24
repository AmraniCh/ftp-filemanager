<?php

use FTPApp\Http\HttpResponse;
use FTPApp\Routing\Route;

return [

    Route::get('/', function () {
        return new HttpResponse("Homepage!");
    }),

    Route::get('/posts/:any-:i', function ($slug, $id) {
        return new HttpResponse("Article $slug and id $id");
    }),

];