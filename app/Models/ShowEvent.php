<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShowEvent extends Model
{
    use HasFactory;

    const AVAILABLE_TIMES = [
        "18:00",
        "18:30",
        "19:00",
        "19:30",
        "20:00",
        "20:30",
        "21:00",
        "21:30",
    ];
    protected $fillable = [
        'show_id',
        'show_date'
    ];

    public function show()
    {
        return $this->belongsTo(Show::class);
    }
}
