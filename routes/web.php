<?php

use Illuminate\Support\Facades\Route;

/*---------------------------------------------------------------------*
 *------------------- GUEST & AUTHENTICATED ROUTES --------------------*
 *---------------------------------------------------------------------*/

// Routes....

/*---------------------------------------------------------------------*
 *--------------------------- GUEST ROUTES ----------------------------*
 *---------------------------------------------------------------------*/
Route::group([
    'middleware'    => [
        'guest:web'
    ]
], function (): void {

    // Routes....
});

/*---------------------------------------------------------------------*
 *----------------------- AUTHENTICATED ROUTES ------------------------*
 *---------------------------------------------------------------------*/
Route::group([
    'middleware'    => [
        'auth:web'
    ]
], function (): void {

    // Routes....
});
