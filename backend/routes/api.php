<?php

use Illuminate\Http\Request;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AccessController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UpdatesController;
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
    Route::put('/edit_user_access/{user}', [UserController::class, 'editUserAccess']);
    Route::get('/add_avatar',[UserController::class,'addAvatar']);
    Route::post('/store_avatar', [UserController::class, 'storeAvatar']);
    Route::get('/get_avatar',[UserController::class,'getAvatar']);
    Route::delete('/delete_user/{user}', [UserController::class, 'deleteUser']);
// USER ROUTES


// ACCESS ROUTES
    Route::get('/get_accesses', [AccessController::class, 'getAccesses']);
    Route::post('/get_access', [AccessController::class, 'getAccess']);
    Route::post('/add_access', [AccessController::class, 'addAccess']);
    Route::put('/edit_access/{access}', [AccessController::class, 'editAccess']);
    Route::delete('/delete_access/{access}', [AccessController::class, 'deleteAccess']);
// ACCESS ROUTES

// DASHBOARD ROUTES
    Route::get('/get_card_done_products', [DashboardController::class, 'getCardDoneProducts']);
    Route::get('/get_card_commissions_val', [DashboardController::class, 'getCardCommissionsVal']);
    Route::get('/get_card_products_registers', [DashboardController::class, 'getCardProductsRegisters']);
    Route::get('/get_info_cards', [DashboardController::class, 'getInfoCards']);
    Route::get('/get_pie_chart_products', [DashboardController::class, 'getPieChartProducts']);
    Route::get('/get_donut_chart_commission_products', [DashboardController::class, 'getDonutChartCommissionProducts']);
    Route::get('/get_column_chart_commission_users', [DashboardController::class, 'getColumnChartCommissionUsers']);
// DASHBOARD ROUTES

// SOFTWARE UPDATES ROUTES
    Route::get('/get_software_updates', [UpdatesController::class, 'getUpdates']);
    Route::get('/get_software_updates_month', [UpdatesController::class, 'getUpdatesMonth']);
    Route::post('/add_update', [UpdatesController::class, 'addUpdate']);
    Route::put('/edit_update/{update}', [UpdatesController::class, 'editUpdate']);
    Route::delete('/delete_update/{update}', [UpdatesController::class, 'deleteUpdate']);
// SOFTWARE UPDATES ROUTES


