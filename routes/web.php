<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MailTestController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\PDFController;
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

Route::redirect('/', 'login', 301);

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard')->with('generateLink', URL::route('subscriptions.generate'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('over')->group(function () {
    //the public email confirmation
    Route::get('/subscriptions/start', [SubscriptionController::class, 'start'])->name('subscriptions.start');
    //the public init email invitation
    Route::post('/subscriptions/init', [SubscriptionController::class, 'publicInit']);
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

    Route::resource('/bookings', BookingController::class);
});

Route::get('mail/test', [MailTestController::class, 'send']);

require __DIR__.'/auth.php';
