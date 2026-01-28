<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InvestmentPlanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\CryptoTransactionController;
use App\Http\Controllers\Admin\CryptoAnalyticsController;
use App\Http\Controllers\Admin\WithdrawalController;
use App\Http\Controllers\Admin\DepositController;
use App\Http\Controllers\Admin\TradingPairController;
use App\Http\Controllers\Admin\AdminInvestmentPlanController;
use App\Http\Controllers\Admin\AdminDepositController;
use App\Http\Controllers\Admin\SettingController;


Route::middleware(['auth','admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    // ===== ADMIN DASHBOARD =====
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // ===== INVESTMENT PLANS =====
    Route::get('/plans', [AdminInvestmentPlanController::class,'index'])->name('plans.index');
    Route::get('/plans/create', [AdminInvestmentPlanController::class,'create'])->name('plans.create');
    Route::post('/plans', [AdminInvestmentPlanController::class,'store'])->name('plans.store');
    Route::get('/plans/{plan}/edit', [AdminInvestmentPlanController::class,'edit'])->name('plans.edit');
    Route::put('/plans/{plan}', [AdminInvestmentPlanController::class,'update'])->name('plans.update');
    Route::delete('/plans/{plan}', [AdminInvestmentPlanController::class,'destroy'])->name('plans.destroy');

    // ===== USERS =====
    Route::get('/users', [UserController::class, 'index'])
        ->name('users.index');
    Route::patch('/users/{user}/toggle', [UserController::class, 'toggle'])
        ->name('users.toggle');
    Route::delete('/users/{user}/toggle', [UserController::class, 'destroy'])
        ->name('users.destroy');
    Route::patch('/users/{user}/toggle-admin', [UserController::class, 'toggleAdmin'])
        ->name('users.toggleAdmin');
    // ===== TRANSACTIONS =====
    Route::get('/transactions', [TransactionController::class, 'index'])
        ->name('transactions.index');

    // ===== CRYPTO DEPOSITS =====
    Route::get('/deposits',[AdminDepositController::class,'index']);
    Route::post('/deposits/{deposit}/approve',[AdminDepositController::class,'approve']);
    Route::post('/deposits/{deposit}/reject',[AdminDepositController::class,'reject']);

    // ===== WITHDRAWALS =====
    Route::get('/withdrawals', [WithdrawalController::class, 'index'])
        ->name('withdrawals.index');

    Route::post('/withdrawals/{withdrawal}/approve',
        [WithdrawalController::class, 'approve'])
        ->name('withdrawals.approve');

    Route::post('/withdrawals/{withdrawal}/reject',
        [WithdrawalController::class, 'reject'])
        ->name('withdrawals.reject');
    

    Route::get('/pairs', [TradingPairController::class, 'index'])
        ->name('pairs.index');

    Route::get('/pairs/create', [TradingPairController::class, 'create'])
        ->name('pairs.create');

    Route::post('/pairs', [TradingPairController::class, 'store'])
        ->name('pairs.store');

    Route::delete('/pairs/{pair}', [TradingPairController::class, 'destroy'])
        ->name('pairs.destroy');

    Route::post('/pairs/{pair}/toggle', [TradingPairController::class, 'toggle'])
        ->name('pairs.toggle');

    // ===== SETTINGS =====
    Route::get('/settings', [SettingController::class, 'index'])
        ->name('settings.index');

    Route::post('/settings', [SettingController::class, 'store'])
        ->name('settings.store');
});
