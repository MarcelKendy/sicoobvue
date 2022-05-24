<?php

use Illuminate\Http\Request;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AccessController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// TASK ROUTES
    Route::get('/get_tasks', [TaskController::class, 'getTasks']);
    Route::get('/get_task/{task}', [TaskController::class, 'getTask']);
    Route::put('/done_task/{task}', [TaskController::class, 'doneTask']);
    Route::post('/add_task', [TaskController::class, 'addTask']);
    Route::put('/edit_task/{task}', [TaskController::class, 'editTask']);
    Route::delete('/delete_task/{task}', [TaskController::class, 'deleteTask']);
// TASK ROUTES


// COMMISSION ROUTES
    Route::get('/get_commissions', [CommissionController::class, 'getCommissions']);
    Route::get('/get_commission/{commission}', [CommissionController::class, 'getCommission']);
    Route::post('/add_commission', [CommissionController::class, 'addCommission']);
    Route::put('/edit_commission/{commission}', [CommissionController::class, 'editCommission']);
    Route::delete('/delete_commission/{commission}', [CommissionController::class, 'deleteCommission']);
// COMMISSION ROUTES


// USER ROUTES
    Route::post('/get_users', [UserController::class, 'getUsers']);
    Route::post('/get_user', [UserController::class, 'getUser']);
    Route::post('/get_user_password', [UserController::class, 'getUserPassword']);
    Route::post('/add_user', [UserController::class, 'addUser']);
    Route::put('/edit_user/{user}', [UserController::class, 'editUser']);
    Route::delete('/delete_user/{user}', [UserController::class, 'deleteUser']);
// USER ROUTES


// ACCESS ROUTES
    Route::get('/get_accesses', [AccessController::class, 'getAccesses']);
    Route::post('/get_access', [AccessController::class, 'getAccess']);
    Route::post('/add_access', [AccessController::class, 'addAccess']);
    Route::put('/edit_access/{access}', [AccessController::class, 'editAccess']);
    Route::delete('/delete_access/{access}', [AccessController::class, 'deleteAccess']);
// ACCESS ROUTES


//Route::get('/get_xml/{xml}', [TaskController::class, 'getXml']);
