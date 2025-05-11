<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'Welcome~',
    ], 200);
})->middleware('auth.client.jwt');

// Auth Routes
require_once __DIR__ . '/api/auth.php';

