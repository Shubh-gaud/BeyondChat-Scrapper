<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'status' => 'Backend running',
        'app' => config('app.name'),
        'time' => now()
    ]);
});
