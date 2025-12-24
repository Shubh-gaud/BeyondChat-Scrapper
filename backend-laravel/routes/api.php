<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

Route::get('/test', function () {
    return 'API OK';
});

Route::apiResource('articles', ArticleController::class);
