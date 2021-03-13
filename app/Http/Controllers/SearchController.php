<?php

namespace App\Http\Controllers;

use App\Http\Requests;

class SearchController extends Controller
{
    //booking search
    public function booking(){
        return view('bookSearch');
    }
}
