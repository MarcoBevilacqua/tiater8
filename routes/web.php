<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MailTestController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ShowController;
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

Route::redirect('/', 'login', 301);

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard')->with('generateLink', URL::route('subscriptions.generate'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('over')->group(function () {
    //the subscription confirmation
    Route::get('/subscriptions/confirmed', [SubscriptionController::class, 'confirmed']);
    //the subscription form visualization
    Route::get('/subscriptions/fill/{token}', [SubscriptionController::class, 'fill'])->name('subscriptions.fill');
    //the subscription submit
    Route::post('/subscriptions/complete', [SubscriptionController::class, 'complete'])->name('subscriptions.complete');
});

Route::middleware(['auth', 'verified'])->group(function () {
    //the init subscription generation link view
    Route::get('/subscriptions/generate', [SubscriptionController::class, 'generate'])->name('subscriptions.generate');
    //the init subscription
    Route::post('/subscriptions/init', [SubscriptionController::class, 'init']);
    //the subscription module PDF preview
    Route::get('/subscriptions/module/{subscriptionId}', [PDFController::class, 'subscriptionModule'])->name('pdf.subscriptions.module');

    Route::resource('/subscriptions', SubscriptionController::class);
    
    Route::resource('/customers', CustomerController::class);

    Route::resource('/shows', ShowController::class);
});

require __DIR__.'/auth.php';
