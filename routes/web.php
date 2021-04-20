<?php

use App\Models\Booking;
use App\Models\Show;
use App\Models\User;
use App\Models\Viewer;
use Illuminate\Support\Facades\Route;

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

    return view('tw/dashboard');

        //nuove prenotazioni
        $new_bookings = DB::table('bookings')
        ->where('booking_date', '>=', time() - (3*(3600*24)))->count();

        //soci da confermare
        $to_confirm = User::where('quota', '=', 'N')->count();

        //prenotazioni non pagate
        $bookings_to_pay = Booking::where('paid', '=', 'N')->count();

        $shows = Show::all();

        //prenotazioni
        $bookings = DB::table('bookings')->where('booking_date', '<=', new DateTime())
            //->join('show_events', 'event_id', '=', 'show_events.id')
            //->select('bookings.*', 'show_events.show_date')
            ->orderBy('booking_date', 'desc')
            ->take(8)
            ->get();

        return view('admin/dashboard')->with(
            array(
                'shows'             => $shows,
                'bookings'          => $bookings,
                'new_bookings'      => $new_bookings,
                'to_confirm'        => $to_confirm,
                'bookings_to_pay'   => $bookings_to_pay
            )
        );
    ///return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
