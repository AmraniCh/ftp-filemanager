<?php

use FTPApp\Controllers\HomepageController;
use FTPApp\Http\HttpResponse;
use FTPApp\Routing\Route;

return [

    Route::get('/', [HomepageController::class, 'index']),

    Route::get('/contact-us', function () {
        return new HttpResponse("This contact us page!");
    }, 'contact'),

    Route::get('/posts/:any-:i', function ($slug, $id) {
        return new HttpResponse("Article $slug and id $id");
    }, 'special-article'),

    new Route(['GET', 'POST'], '/users', function () {
       echo 'Users page.';
    }),

];