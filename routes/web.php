<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\PublicSubscriptionController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\ShowEventController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SubscriptionRenewController;
use App\Http\Controllers\SubscriptionStatusController;
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
    Route::get('/subscriptions/start', [PublicSubscriptionController::class, 'create'])
        ->name('subscriptions.start');
    //the public init subscription
    Route::post('/subscriptions/init', [PublicSubscriptionController::class, 'store']);
    //the subscription form visualization
    Route::get('/subscriptions/fill/{token}', [PublicSubscriptionController::class, 'edit'])
        ->name('subscriptions.fill');
    //the subscription renew form
    Route::get('/subscriptions/renew/{customer_email}', [SubscriptionRenewController::class, 'index'])
        ->name('subscriptions.renew');
    //the subscription renew action
    Route::post('/subscriptions/renew', [SubscriptionRenewController::class, 'store']);
    //the subscription submit
    Route::post('/subscriptions/complete', [PublicSubscriptionController::class, 'update'])
        ->name('subscriptions.complete');
});

Route::middleware(['auth', 'verified'])->group(function () {
    //the init subscription generation link view
    Route::get('/subscriptions/generate', [PublicSubscriptionController::class, 'show'])
        ->name('subscriptions.generate');
    //the init subscription
    Route::post('/subscriptions/init', [PublicSubscriptionController::class, 'store']);
    //the subscription module PDF preview
    Route::get('/subscriptions/module/{subscriptionId}', [PDFController::class, 'subscriptionModule'])
        ->name('pdf.subscriptions.module');

    // changing status
    Route::patch('/subscriptions/{subscription}/status/{status}', [SubscriptionStatusController::class, 'update'])
        ->name('subscriptions.update-status');

    //Bookings detail
    Route::get('/bookings/show-event/{show_event_id}', [BookingController::class, 'detail'])->name('bookings.detail');

    Route::resource('/subscriptions', SubscriptionController::class);

    Route::resource('/customers', CustomerController::class);

    Route::resource('/bookings', BookingController::class);

    Route::resource('/shows', ShowController::class);

    Route::resource('/show-events', ShowEventController::class);

    Route::get('/events/{showId}', [ShowEventController::class, 'forShow']);
});

require __DIR__ . '/auth.php';
