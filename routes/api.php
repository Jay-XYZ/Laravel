<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TableController;
use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'token.message'])->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    
    // STUDENT ROUTES - RESTful convention
    // All authenticated users can view
    Route::get('/students', [TableController::class, 'getAllStudents']);      // GET /students - list all
    Route::get('/students/{id}', [TableController::class, 'show']);           // GET /students/1 - get one
    
    // Only admins can modify
    Route::middleware(['role:admin'])->group(function () {
        Route::post('/students', [TableController::class, 'store']);          // POST /students - create
        Route::put('/students/{id}', [TableController::class, 'update']);     // PUT /students/1 - update
        Route::delete('/students/{id}', [TableController::class, 'destroy']); // DELETE /students/1 - delete
    });
});

// Optional: If you want to keep the old endpoint for compatibility
Route::get('/getAllStudents', [TableController::class, 'getAllStudents'])
    ->middleware(['auth:sanctum', 'token.message']);