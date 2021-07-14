<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard')->with('generateLink', URL::route('subscriptions.generate'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('public')->group(function(){
    //the subscription form visualization (should be public)
    Route::get('/subscriptions/{token}', [SubscriptionController::class, 'fill']);
    //the subscription submit (should be public)
    Route::post('/subscriptions/complete', [SubscriptionController::class, 'complete']);
});

Route::middleware(['auth', 'verified'])->group(function () {
    //the init subscription generation link view
    Route::get('/subscriptions/generate', [SubscriptionController::class, 'generate'])->name('subscriptions.generate');
    //the init subscription
    Route::post('/subscriptions/init', [SubscriptionController::class, 'init']);
    Route::resource('/subscriptions', SubscriptionController::class);
    
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers');
});

require __DIR__.'/auth.php';
