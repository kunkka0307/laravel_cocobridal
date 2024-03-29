<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
    'as' => 'admin.'
], function () { // custom admin routes
    Route::crud('tag', 'TagController');
    Route::crud('room', 'RoomCrudController');
    Route::crud('party', 'PartyCrudController');
    Route::crud('user', 'UserCrudController');
    Route::crud('book', 'BookCrudController');
    Route::crud('page', 'PageCrudController');
}); // this should be the absolute last line of this file