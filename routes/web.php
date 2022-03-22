<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MailTestController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\PublicSubscriptionController;
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
    //the public email confirmation
    Route::get('/subscriptions', [PublicSubscriptionController::class, 'index']);
    //the public subscription entry point
    Route::get('/subscriptions/start', [PublicSubscriptionController::class, 'create'])->name('subscriptions.start');
    //the public init subscription
    Route::post('/subscriptions/init', [PublicSubscriptionController::class, 'store']);
    //the subscription form visualization
    Route::get('/subscriptions/fill/{token}', [PublicSubscriptionController::class, 'edit'])->name('subscriptions.fill');
    //the subscription submit
    Route::post('/subscriptions/complete', [PublicSubscriptionController::class, 'update'])->name('subscriptions.complete');
});

Route::middleware(['auth', 'verified'])->group(function () {
    //the init subscription generation link view
    Route::get('/subscriptions/generate', [PublicSubscriptionController::class, 'show'])->name('subscriptions.generate');
    //the init subscription
    Route::post('/subscriptions/init', [PublicSubscriptionController::class, 'store']);
    //the subscription module PDF preview
    Route::get('/subscriptions/module/{subscriptionId}', [PDFController::class, 'subscriptionModule'])->name('pdf.subscriptions.module');
    // changing status
    Route::patch('/subscriptions/{subscription}/status/{status}', [SubscriptionController::class, 'updateStatus'])->name('subscriptions.update-status');

    Route::resource('/subscriptions', SubscriptionController::class);
    
    Route::resource('/customers', CustomerController::class);

    Route::resource('/shows', ShowController::class);
});

require __DIR__.'/auth.php';
