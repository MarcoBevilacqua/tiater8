<?php

namespace App\Services;

use Carbon\Carbon;

class ShowEventService
{
    public static function createCompleteDate(String $date, String $time)
    {
        return Carbon::createFromTimeString($date . ' ' . $time);
    }
}
